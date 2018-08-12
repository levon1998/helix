<?php
/**
 * Created by PhpStorm.
 * User: levon
 * Date: 8/12/2018
 * Time: 7:32 PM
 */

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class DownloadArchive
{
    /**
     * Function to download File from $source param by curl
     *
     * @param $source
     *
     * @return Boolean
     */
    public static function download($source)
    {
        $guzzle = new Client();
        $response = $guzzle->get($source, ['timeout' => 30]);
        return Storage::put('public/geonames/geonames.zip', $response->getBody());
    }
}