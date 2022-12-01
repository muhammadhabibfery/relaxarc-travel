<?php

namespace App\Repositories\TravelGallery;

use App\Models\TravelGallery;
use App\Repositories\TravelGallery\TravelGalleryRepositoryInterface;

class TravelGalleryRepository implements TravelGalleryRepositoryInterface
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
    public function __construct(TravelGallery $model)
    {
        $this->model = $model;
    }

    /**
     * query a travel gallery by slug
     *
     * @param  string|null $slug
     * @return $this
     */
    public function findOneTravelGalleryBySlug(?string $slug = null)
    {
        $this->modelResult = $this->model->where('slug', $slug);

        return $this;
    }

    /**
     * get a travel gallery, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound()
    {
        return $this->modelResult->firstOrFail();
    }

    /**
     *  Creating a new travel gallery
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     *  Deleting  a travel galery selected
     *
     * @return void
     */
    public function delete()
    {
        return $this->model->delete();
    }
}
