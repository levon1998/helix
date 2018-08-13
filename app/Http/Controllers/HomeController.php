<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityValidationRequest;
use App\Http\Requests\SearchAjaxPost;
use App\Models\GeoName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     *  Function to render index page
     *
     * @return view
     */
    public function index()
    {
        return view('layouts.user.pages.index');
    }

    /**
     * Function to return autocomplate data
     * @param SearchAjaxPost $request
     * @return json
     */
    public function autoCompleteSearch(SearchAjaxPost $request)
    {
        //Get search result
        $data = GeoName::getSearchResult($request->input('word'));

        return json_decode($data);
    }

    /**
     * Function to return autocomplate data
     * @param CityValidationRequest $request
     * @return json
     */
    public function nearestCities(CityValidationRequest $request)
    {
        $city = GeoName::getCity($request->input('city_id'));
        //Get nearest 20 cities, for more readable should be use SQLYog ))
        $nearestCities = DB::select("SELECT `geonameid`, `name`, `latitude`, `longtitude`, (3959 * ACOS(COS(RADIANS(?)) * COS(RADIANS(latitude)) * COS( RADIANS(longtitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(latitude)))) AS distance FROM geoname ORDER BY distance LIMIT 0 , 20", [$city->latitude, $city->longtitude, $city->latitude]);

        return $nearestCities;
    }
}
