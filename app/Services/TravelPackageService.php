<?php

namespace App\Services;

use App\Repositories\TravelPackage\TravelPackageRepositoryInterface;
use App\Traits\ImageHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TravelPackageService
{

    use ImageHandler;

    /**
     * The name of temporary model instance
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $temporaryModel;

    /**
     * The name of repository instance
     *
     * @var App\Repositories\TravelPackage\TravelPackageRepositoryInterface
     */
    private $travelPackageRepository;


    /**
     * Create a new repository instance.
     *
     * @param   App\Repositories\TravelPackage\TravelPackageRepositoryInterface  $travelPackageRepositoryInterface
     * @return void
     */
    public function __construct(TravelPackageRepositoryInterface $travelPackageRepositoryInterface)
    {
        $this->travelPackageRepository = $travelPackageRepositoryInterface;
    }

    /**
     * Take all travel packages from database
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function takeAllTravelPackages(Request $request)
    {
        return $this->travelPackageRepository->getAllTravelPackagesByKeywordOrStatus($request->keyword, $request->status)
            ->latest()
            ->paginate(10);
    }

    /**
     * Take all travel packages from database
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function takeAllAvailableTravelPackagesWithRelations(array $relations)
    {
        return $this->travelPackageRepository->getAllTravelPackagesByKeywordOrStatus()
            ->select(['id', 'title', 'slug', 'location'])
            ->onlyAvailable()
            ->withRelations($relations)
            ->paginate(10);
    }

    /**
     * Take all deleted travel packages from database
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function takeAllDeletedTravelPackages(Request $request)
    {
        return $this->travelPackageRepository->getAllTravelPackagesByKeywordOrStatus($request->keyword, $request->status, true)
            ->latest()
            ->paginate(10);
    }

    /**
     * Take one travel package from database
     *
     * @param  string|null $slug
     * @param  string|null $action get one travel package for action (update or delete) it self
     * @return \Illuminate\Database\Eloquent\Model|array
     */
    public function takeOneTravelPackage(?string $slug, ?string $action = null)
    {
        $model = $this->travelPackageRepository->findOneTravelPackageByslug($slug)
            ->firstOrNotFound();

        if ($action) {
            $this->temporaryModel = $model;
            return [$model, $this];
        }

        return $model;
    }

    public function takeOneTravelPackageWithRelations(?string $slug, array $relations)
    {
        return $this->travelPackageRepository->findOneTravelPackageByslug($slug)
            ->firstOrNotFound()
            ->load($relations);
    }

    /**
     * Store travel package to database
     *
     * @param  array $validatedData
     * @return void
     */
    public function storeTravelPackage(array $validatedData)
    {
        $data = $this->mergeData(
            $validatedData,
            [
                'created_by' => auth()->id(),
                'price' => $this->convertPriceType($validatedData['price']),
                'date_completion' => Carbon::parse($validatedData['date_departure'])->addDays($validatedData['duration'])
            ]
        );

        if (!$this->travelPackageRepository->create($data)) throw new \Exception(trans('status.failed_create_new_travel_package'));

        return $this;
    }

    /**
     * update travel package selected to database
     *
     * @param  array $validatedData
     * @param  bool $mergeData merge some data with additional data
     * @return void
     */
    public function updateTravelPackage(array $validatedData, bool $mergeData = true)
    {
        $data = ($mergeData)
            ? $this->mergeData(
                $validatedData,
                [
                    'updated_by' => auth()->id(),
                    'price' => $this->convertPriceType($validatedData['price']),
                    'date_completion' => Carbon::parse($validatedData['date_departure'])->addDays($validatedData['duration'])
                ]
            )
            : $validatedData;

        if (!$this->temporaryModel->update($data)) throw new \Exception(trans('status.failed_update_travel_package'));

        return $this;
    }

    /**
     * delete travel package selected using soft delete
     *
     * @param  array $dataDeletedBy
     * @return void
     */
    public function softDeleteTravelPackage()
    {
        if (!$this->temporaryModel->delete()) throw new \Exception(trans('status.failed_delete_travel_package'));

        return $this;
    }

    /**
     * Take one deleted travel package from database
     *
     * @param  string|null $slug
     * @param  string|null $action get one deleted travel package for action (restore or force delete) it self
     * @return \Illuminate\Database\Eloquent\Model|array
     */
    public function takeOneDeletedTravelPackage(?string $slug, ?string $action = null)
    {
        $model = $this->travelPackageRepository->findOneTravelPackageByslug($slug)
            ->onlyDeleted()
            ->firstOrNotFound();

        if ($action) {
            $this->temporaryModel = $model;
            return [$model, $this];
        }

        return $model;
    }

    public function restoreDeletedTravelPackage()
    {
        if (!$this->temporaryModel->restore()) throw new \Exception(trans('status.failed_restore_travel_package'));

        return $this;
    }

    /**
     * remove or force delete deleted travel package selected
     *
     * @return $this
     */
    public function removeDeletedTravelPackage()
    {
        if (!$this->temporaryModel->forceDelete()) throw new \Exception(trans('status.failed_delete_permanent_travel_package'));
        $this->temporaryModel = null;

        return $this;
    }

    /**
     * delete deleted travel package images, using the relationship
     *
     * @return $this
     */
    public function deleteTravelPackageImages()
    {
        $galleries = $this->temporaryModel->travelGalleries;

        if ($galleries->count()) {
            foreach ($galleries as $gallery) $this->deleteImage($gallery->name, 'travel-galleries', 'travel-galleries/thumbnails');
        }

        return $this;
    }

    /**
     * use db transaction for wrap multiple database queries
     *
     * @param  callable $action
     * @return void
     */
    public function useDBTransaction(callable $action)
    {
        $this->travelPackageRepository->transaction($action);

        return $this;
    }

    /**
     * Merge main data and additional data
     *
     * @param array $additonalData
     * @param array $additionalData
     * @return array
     */
    private function mergeData(array $mainData, array $additionalData)
    {
        return array_merge($mainData, $additionalData);
    }

    /**
     * Convert price type to integer
     *
     * @param  string $value
     * @return integer
     */
    private function convertPriceType(string $value)
    {
        return (int) preg_replace("/[^0-9]/", "", $value);
    }
}
