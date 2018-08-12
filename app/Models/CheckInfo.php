<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckInfo extends Model
{
    public $timestamps = false;
    protected $table   = "check_info";

    /**
     * Function to create new row in to check_info table
     * @param $name
     * @param $hash
     * @return bool
     */
    public function createNew($name, $hash)
    {
        $this->name  = "Geo Names";
        $this->hash  = $hash;

        return $this->save();
    }
}
