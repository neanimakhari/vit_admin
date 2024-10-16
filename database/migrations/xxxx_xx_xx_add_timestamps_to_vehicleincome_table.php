<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToVehicleincomeTable extends Migration
{
    public function up()
    {
        Schema::table('vehicleincome', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('vehicleincome', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
