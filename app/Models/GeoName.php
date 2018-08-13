<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoName extends Model
{
    public $timestamps = false;
    protected $table   = "geoname";

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        "geonameid",
        "name",
        "asciiname",
        "alternatenames",
        "latitude",
        "longtitude",
        "feature_class",
        "feature_code",
        "country_code",
        "cc2",
        "admin1_code",
        "admin2_code",
        "admin3_code",
        "admin4_code",
        "population",
        "elevation",
        "gtopo30",
        "timezone",
        "modification_date",
    ];

    /**
     * Function to return fillable
     * @return array
     */
    public function getFields()
    {
        return $this->fillable;
    }

    /**
     * Function to get search result
     *
     * @param $word
     * @return mixed
     */
    public static function getSearchResult($word)
    {
        return Self::select('geonameid', 'name', 'country_code')
            ->orWhere('name', 'like', "%$word%")
            ->orWhere('asciiname', 'like', "%$word%")
            ->orWhere('country_code', 'like', "%$word%")
            ->limit(100)
            ->get();
    }

    /**
     * Function to get city by id
     *
     * @param $cityId
     * @return mixed
     */
    public static function getCity($cityId)
    {
        return self::select('geonameid', 'name', 'latitude', 'longtitude')
            ->where('geonameid', $cityId)
            ->first();
    }
}
