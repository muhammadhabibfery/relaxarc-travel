<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelGallery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the travel gallery that owns the travel package.
     */
    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class);
    }


    /**
     * set the travel galleries title and slug
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::ucfirst($value);
        $this->attributes['slug'] = Str::lower(Str::slug(head(explode('.', preg_replace('/[^A-Za-z0-9\. ]/', '', $value)))));
    }

    /**
     * get travel gallery image
     *
     * @return mixed
     */
    public function getImage()
    {
        return asset("/storage/travel-galleries/{$this->name}");
    }

    /**
     * get travel gallery thumbnail
     *
     * @return mixed
     */
    public function getThumbnail()
    {
        return asset("/storage/travel-galleries/thumbnails/{$this->name}");
    }
}
