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
     * get a travel package by id, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByIdOrNotFound(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * query all travel packages by keyword
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
     * query all deleted travel packages by keyword
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
    public function getAllTravelPackagesByKeywordOrStatus(?string $keyword = '', ?string $status = null, bool $deletedTravelPackages = false)
    {
        $this->modelResult = ($deletedTravelPackages)
            ?  $this->findAllDeletedTravelPackagesByKeyword($keyword)
            : $this->findAllTravelPackagesByKeyword($keyword);

        if (!empty($status) && in_array($status, ['<', '>', '!'])) $this->modelResult = $this->modelResult->withStatus($status);

        return $this;
    }

    /**
     * query a travel package by slug
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
     * query specified select columns
     *
     * @param  array $columns
     * @return $this
     */
    public function select(array $columns)
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->select($columns);

        return $this;
    }

    /**
     * query only available travel packages
     *
     * @return $this
     */
    public function onlyAvailable()
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->where('date_departure', '>', now());

        return $this;
    }

    /**
     * query ordering by created_at column descending
     *
     * @return $this
     */
    public function latest()
    {
        $this->modelResult->latest();

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
     * query the travel packages relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withRelations(array $relations)
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->with($relations);

        return $this;
    }

    /**
     * counting a travel package's relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withCountRelations(array $relations)
    {
        $this->modelResult->withCount($relations);

        return $this;
    }

    /**
     * query a travel package's relations existence
     *
     * @param  string $relations
     * @return $this
     */
    public function hasRelations(string $relations)
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->has($relations);

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
     * query the travel packages with limit the number of result
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function limit(int $number)
    {
        $this->modelResult->limit($number);

        return $this;
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
     * get all travel packages and add paginate with the limit
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number)
    {
        return $this->modelResult->paginate($number);
    }

    /**
     * count all travel packages
     *
     * @return int
     */
    public function count()
    {
        $this->checkDefineModelResultProperty();

        return $this->modelResult->count();
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
     * wrap multiple database queries using database transaction
     *
     * @param  callable $action
     * @return void
     */
    public function transaction(callable $action)
    {
        return DB::transaction($action);
    }

    /**
     * check and define modelresult property
     *
     * @return void
     */
    public function checkDefineModelResultProperty()
    {
        if (!$this->modelResult) $this->modelResult = $this->model->query();
    }
}
