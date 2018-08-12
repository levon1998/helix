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
}
