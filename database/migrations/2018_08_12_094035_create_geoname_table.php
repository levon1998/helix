<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeonameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geoname', function (Blueprint $table) {
            $table->increments('geonameid')->index();
            $table->string('name')->index();
            $table->string('asciiname')->nullable();
            $table->text('alternatenames')->nullable();
            $table->decimal('latitude',9, 6)->nullable(false)->index();
            $table->decimal('longtitude',9, 6)->nullable(false)->index();
            $table->string('feature_class')->nullable();
            $table->string('feature_code')->nullable();
            $table->string('country_code')->nullable();
            $table->string('cc2')->nullable();
            $table->string('admin1_code')->nullable();
            $table->string('admin2_code')->nullable();
            $table->string('admin3_code')->nullable();
            $table->string('admin4_code')->nullable();
            $table->bigInteger('population')->nullable();
            $table->bigInteger('elevation')->nullable();
            $table->integer('gtopo30')->nullable();
            $table->string('timezone')->nullable();
            $table->date('modification_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geoname');
    }
}
