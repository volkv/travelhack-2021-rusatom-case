<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExistingTables extends Migration
{

    static array $tables = ['events','places'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::$tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedInteger('google_trends')->nullable();
                $table->unsignedInteger('relevance')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (self::$tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedInteger('google_trends')->nullable();
                $table->unsignedInteger('relevance')->nullable();

            });
        }
    }
}
