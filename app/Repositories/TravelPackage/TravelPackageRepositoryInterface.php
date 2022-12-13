<?php

namespace App\Repositories\TravelPackage;

interface TravelPackageRepositoryInterface
{
    /**
     * get a travel package by id, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByIdOrNotFound(int $id);

    /**
     * query all travel packages by keyword
     *
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     *
     */
    public function findAllTravelPackagesByKeyword(?string $keyword);

    /**
     * query all deleted travel packages by keyword
     *
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findAllDeletedTravelPackagesByKeyword(?string $keyword);

    /**
     * get spesific all travel packages by keyword or status
     *
     * @param  string|null $keyword
     * @param  string|null $status
     * @param  bool $deletedTravelPackages
     * @return $this
     */
    public function getAllTravelPackagesByKeywordOrStatus(?string $keyword, ?string $status, bool $deletedTravelPackages);

    /**
     * query a travel package by slug
     *
     * @param  string|null $slug
     * @return $this
     */
    public function findOneTravelPackageByslug(?string $slug);

    /**
     * query specified select columns
     *
     * @param  array $columns
     * @return $this
     */
    public function select(array $columns);

    /**
     * query only available travel packages
     *
     * @return $this
     */
    public function onlyAvailable();

    /**
     * query ordering by created_at column descending
     *
     * @return $this
     */
    public function latest();

    /**
     * query a travel package only deleted
     *
     * @return $this
     */
    public function onlyDeleted();

    /**
     * query the travel packages relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withRelations(array $relations);

    /**
     * query a travel package's relations existence
     *
     * @param  string $relations
     * @return $this
     */
    public function hasRelations(string $relations);

    /**
     * counting a travel package's relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withCountRelations(array $relations);

    /**
     * get all travel packages and transform to collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get();

    /**
     * query the travel packages with limit the number of result
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function limit(int $number);

    /**
     * get a travel package, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound();

    /**
     * get all travel packages and add paginate with the limit
     *
     * @param  int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number);

    /**
     * count all travel packages
     *
     * @return int
     */
    public function count();

    /**
     *  Creating a new travel package
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data);

    /**
     *  Updating a travel package selected
     *
     * @param  array $data
     * @return void
     */
    public function update(array $data);

    /**
     *  Deleting  a travel package selected
     *
     * @return void
     */
    public function delete();

    /**
     * restoring a deleted travel package selected
     *
     * @return void
     */
    public function restore();

    /**
     * removing a deleted travel package selected
     *
     * @return void
     */
    public function forceDelete();

    /**
     * wrap multiple database queries using database transaction
     *
     * @param  callable $action
     * @return void
     */
    public function transaction(callable $action);

    /**
     * check and define modelresult property
     *
     * @return void
     */
    public function checkDefineModelResultProperty();
}
