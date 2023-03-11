<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumns1ToRepairJobSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repair_job_sheets', function (Blueprint $table) {
            $table->integer('service_staff2')
                ->nullable()->unsigned();
            $table->foreign('service_staff2')
                ->references('id')->on('users');
            $table->string('hotel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repair_job_sheets', function (Blueprint $table) {
            //
        });
    }
}
