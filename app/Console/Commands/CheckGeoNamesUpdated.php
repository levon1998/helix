<?php

namespace App\Console\Commands;

use App\Jobs\ImportNewData;
use App\Models\CheckInfo;
use App\Services\ArchiveService;
use App\Services\DownloadArchive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckGeoNamesUpdated extends Command
{
    private $source;
    private $fileName;
    private $hashedFile;
    private $extractPath;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:geonames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update the cities table in MySql database if the source is updated(link "http://download.geonames.org/export/dump/RU.zip"), if the source is not updated do not update the local database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->extractPath = public_path().'/storage/geonames/';
        $this->fileName    = public_path().'/storage/geonames/geonames.zip';
        $this->source      = "http://download.geonames.org/export/dump/RU.zip";
        $this->hashedFile  = public_path().'/storage/geonames/RU.txt';
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', "512M");

        try {
            //Download source
            DownloadArchive::download($this->source);
            //UnZip downloaded file
            ArchiveService::extract($this->fileName, $this->extractPath);
            //Delete readme.txt and geonames.zip
            ArchiveService::deleteUnnecessaryFiles();
            //Generate file hash by md5
            $hashed = hash_file('md5', $this->hashedFile);
            //Get hash and check it and dispatch job
            $check = CheckInfo::first();

            if ($check) {
                if ($hashed != $check->hash) {
                    dispatch(new ImportNewData());
                }
            } else {
                $checkInfo = new CheckInfo();
                $checkInfo->createNew("Geo Names", $hashed);

                dispatch(new ImportNewData());
            }
        } catch (\Throwable $e) {
            Log::info("CheckGeoNamesUpdated {$e->getMessage()}");
        }
    }
}
