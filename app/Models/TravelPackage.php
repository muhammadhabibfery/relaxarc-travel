<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPackage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the travel galleries for the travel package
     *
     *
     */
    public function travelGalleries()
    {
        return $this->hasMany(TravelGallery::class);
    }

    /**
     * Get the transactions for the travel package
     *
     *
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * set the travel package's title
     *
     * @param  string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Str::title($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * set the travel package's location
     *
     * @param  string $value
     * @return void
     */
    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = Str::title($value);
    }

    /**
     * set the travel package's about
     *
     * @param  string $value
     * @return void
     */
    public function setAboutAttribute($value)
    {
        $this->attributes['about'] = ucfirst($value);
    }

    /**
     * set the travel package's duration
     *
     * @param  string $value
     * @return void
     */
    public function setDurationAttribute($value)
    {
        $this->attributes['duration'] = Str::upper($value);
    }

    /**
     * set the travel package's type
     *
     * @param  string $value
     * @return void
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Str::title($value);
    }

    /**
     * get the travel package's date departure
     *
     * @param  string $value
     * @return string
     */
    public function getDateDepartureAttribute($value)
    {
        return transformDateFormat($value, 'Y-m-d H:i');
    }

    /**
     * get the travel package's date departure with custom property and date format
     *
     * @return string
     */
    public function getDateDepartureWithDayAttribute()
    {
        return transformDateFormat($this->date_departure, 'l, d-F-Y H:i');
    }

    /**
     * get the travel package's date departure with custom property and date format
     *
     * @return boolean
     */
    public function getDateDepartureAvailableAttribute()
    {
        return $this->date_departure > now();
    }

    /**
     * get first travel galleries for the travel package
     *
     * @return void
     */
    public function getFirstThumbnailAttribute()
    {
        return $this->travelGalleries()->first()
            ? $this->travelGalleries()->first()->getThumbnail()
            : asset('assets/backend/img/no-image.png');
    }

    /**
     * Scope a query to only include status of travel package's date departure.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('date_departure', $status, now());
    }


    /**
     * Get the matching result of travel package's type
     *
     * @param  string $value
     * @param  string $comparison
     * @return boolean
     */
    public function isMatchType($value, $comparison)
    {
        return old('type', $value) == $comparison;
    }
}
