<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_package_id', 'name', 'slug', 'uploaded_by', 'updated_by', 'deleted_by'
    ];

    public function getImage()
    {
        return asset("/storage/travel-galleries/{$this->name}");
    }

    public function getThumbnail()
    {
        return asset("/storage/travel-galleries/thumbnails/{$this->name}");
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::ucfirst($value);
    }

    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class);
    }
}
