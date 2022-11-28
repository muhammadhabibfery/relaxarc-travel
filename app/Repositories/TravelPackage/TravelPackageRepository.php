<?php

namespace App\Repositories\TravelPackage;

use App\Models\TravelPackage;
use App\Repositories\TravelPackage\TravelPackageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TravelPackageRepository implements TravelPackageRepositoryInterface
{

    /**
     * The name of model instance
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;

    /**
     * The name of last query model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $modelResult;

    /**
     * Create a new Eloquent model instance.
     *
     * @param   Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function __construct(TravelPackage $model)
    {
        $this->model = $model;
    }

    /**
     * query all travel packages by keyword for index page
     *
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findAllTravelPackagesByKeyword(?string $keyword)
    {
        return $this->model->where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%$keyword%")
                ->orWhere('location', 'LIKE', "%$keyword%");
        });
    }

    /**
     * query all deleted travel packages by keyword for index trash page
     *
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findAllDeletedTravelPackagesByKeyword(?string $keyword)
    {
        return $this->model->onlyTrashed()
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('location', 'LIKE', "%$keyword%");
            });
    }

    /**
     * get spesific all travel packages by keyword or status
     *
     * @param  string|null $keyword
     * @param  string|null $status
     * @param  bool $deletedTravelPackages Get only deleted travel packages
     * @return $this
     */
    public function getAllTravelPackagesByKeywordOrStatus(?string $keyword, ?string $status, bool $deletedTravelPackages = false)
    {
        $this->modelResult = ($deletedTravelPackages)
            ?  $this->findAllDeletedTravelPackagesByKeyword($keyword)
            : $this->findAllTravelPackagesByKeyword($keyword);

        if (!empty($status) && in_array($status, ['<', '>'])) $this->modelResult = $this->modelResult->withStatus($status);

        return $this;
    }

    /**
     * query a travel package by keyword for index page
     *
     * @param  string|null $slug
     * @return $this
     */
    public function findOneTravelPackageByslug(?string $slug)
    {
        $this->modelResult = $this->model->where('slug', $slug);

        return $this;
    }

    /**
     * query a travel package only deleted
     *
     * @return $this
     */
    public function onlyDeleted()
    {
        $this->modelResult->onlyTrashed();

        return $this;
    }

    /**
     * get all travel packages and transform to collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->modelResult->get();
    }

    /**
     * get a travel package, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound()
    {
        return $this->modelResult->firstOrFail();
    }

    /**
     * get all travel packages and add paginate with descending order
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number)
    {
        return $this->modelResult->latest()
            ->paginate($number);
    }

    /**
     *  Creating a new travel package
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     *  Updating a travel package selected
     *
     * @param  array $data
     * @return void
     */
    public function update(array $data)
    {
        return $this->model->update($data);
    }

    /**
     *  Deleting  a travel package selected
     *
     * @return void
     */
    public function delete()
    {
        return $this->model->delete();
    }

    /**
     * restoring a deleted travel package selected
     *
     * @return void
     */
    public function restore()
    {
        return $this->model->restore();
    }

    /**
     * removing a deleted travel package selected
     *
     * @return void
     */
    public function forceDelete()
    {
        return $this->model->forceDelete();
    }

    /**
     * wrap multiple database queries
     *
     * @param  callable $action
     * @return void
     */
    public function transaction(callable $action)
    {
        return DB::transaction($action);
    }
}
