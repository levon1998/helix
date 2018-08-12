<?php

namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use ZipArchive;

class ArchiveService
{
    /**
     * Function to extract zip files
     *
     * @param $fileName
     * @param $extractPath
     *
     * @return Boolean
     */
    public static function extract($fileName, $extractPath)
    {
        $extract = false;
        $zip = new ZipArchive;
        $zipped = $zip->open($fileName);

        if ($zipped) {
            $extract = $zip->extractTo($extractPath);

            if(!$extract){
                $now = Carbon::now()->format("Y-m-d H:i:s");
                Log::info("Your file is not extracted. {$now}");
            }
            $zip->close();
        }

        return $extract;
    }

    /**
     * Function to remove unnecessary files
     *
     * @return Boolean
     */
    public static function deleteUnnecessaryFiles()
    {
        return Storage::delete(['public/geonames/readme.txt','public/geonames/geonames.zip']);
    }
}