<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'location', 'about', 'featured_event', 'language', 'foods', 'date_departure', 'duration', 'type', 'price', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Str::title($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = Str::title($value);
    }

    public function setAboutAttribute($value)
    {
        $this->attributes['about'] = ucfirst($value);
    }

    public function setDurationAttribute($value)
    {
        $this->attributes['duration'] = Str::upper($value);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Str::title($value);
    }

    public function getLanguageAttribute($value)
    {
        return Str::contains($value, ',') ? explode(',', $value) : $value;
    }

    public function getFeaturedEventAttribute($value)
    {
        return Str::contains($value, ',') ? explode(',', $value) : $value;
    }

    public function getFoodsAttribute($value)
    {
        return Str::contains($value, ',') ? explode(',', $value) : $value;
    }

    public function getDurationAttribute($value)
    {
        return (Str::contains($value, 'D')) ? str_replace('D', ' Hari', $value) : $value;
    }

    public function getDateDepartureAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('Y-m-d H:i');
    }
    public function getDateDepartureWithDayAttribute()
    {
        return Carbon::parse($this->date_departure)->translatedFormat('l, d-F-Y H:i');
    }

    public function travelGalleries()
    {
        return $this->hasMany(TravelGallery::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
