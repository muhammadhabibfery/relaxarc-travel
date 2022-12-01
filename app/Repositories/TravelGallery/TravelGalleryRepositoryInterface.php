<?php

namespace App\Repositories\TravelGallery;

interface TravelGalleryRepositoryInterface
{
    /**
     * query a travel gallery by slug
     *
     * @param  string|null $slug
     * @return $this
     */
    public function findOneTravelGalleryBySlug(?string $slug = null);

    /**
     * get a travel gallery, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound();

    /**
     *  Creating a new travel gallery
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data);

    /**
     *  Deleting  a travel galery selected
     *
     * @return void
     */
    public function delete();
}
