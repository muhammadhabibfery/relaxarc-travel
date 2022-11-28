<?php

namespace App\Repositories\TravelPackage;

interface TravelPackageRepositoryInterface
{
    /**
     * query all travel packages by keyword for index page
     *
     * @param  string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     *
     */
    public function findAllTravelPackagesByKeyword(?string $keyword);

    /**
     * query all deleted travel packages by keyword for index trash page
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
     * query a travel package by keyword for index page
     *
     * @param  string|null $slug
     * @return $this
     */
    public function findOneTravelPackageByslug(?string $slug);

    /**
     * query a travel package only deleted
     *
     * @return $this
     */
    public function onlyDeleted();

    /**
     * get all travel packages and transform to collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get();

    /**
     * get a travel package, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound();

    /**
     * get all travel packages and add paginate with descending order
     *
     * @param  int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number);

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
     * wrap multiple database queries
     *
     * @param  callable $action
     * @return void
     */
    public function transaction(callable $action);
}
