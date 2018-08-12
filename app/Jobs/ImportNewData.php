<?php

namespace App\Jobs;

use App\Models\GeoName;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportNewData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
        try {
            //Get all lines from RU.txt
            $lines = file(public_path().'/storage/geonames/RU.txt', FILE_IGNORE_NEW_LINES );

            //Get fallible
            $geoName = new GeoName();
            $columns = $geoName->getFields();

            //Get insertion array
            $fields = array_map(function($array) use ($columns) {
                return array_combine($columns, $this->explodeRow($array));
            }, $lines);

            //Insert By transaction
            $timeStart = microtime(true);
                DB::transaction(function () use ($fields){
                    // Remove all data in geo_name table
                    GeoName::truncate();

                    foreach ($fields as $field) {
                        GeoName::insert($field);
                    }
                });
            $timeEnd = microtime(true);
            $executionTime = ($timeEnd - $timeStart);

            Log::info("Job is successfully. Execution Time is {$executionTime}");
        } catch (\Throwable $e) {
            Log::info("Job failed {$e->getMessage()}");
        }

    }

    /**
     * Function to explode each line in import txt file
     *
     * @param $item
     * @return array
     */
    public function explodeRow($item) {
        return array_map(function ($value) {
            return ($value == '') ? null : $value;
        },explode("\t", $item));
    }
}
