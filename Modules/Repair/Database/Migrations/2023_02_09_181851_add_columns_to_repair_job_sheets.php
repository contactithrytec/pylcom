<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToRepairJobSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repair_job_sheets', function (Blueprint $table) {
            DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            $table->String('code_site');
            $table->String('machine_voltage');
            $table->String('compressor')->nullable();
            $table->String('detector_test')->default('yes');
            $table->String('test_alarms')->default('yes');
            $table->time('work_hour')->nullable();
            $table->time('entry_time')->nullable();
            $table->time('exit_time')->nullable();
            $table->time('total_travel_time_go')->nullable();
            $table->time('total_travel_time_return')->nullable();
            $table->float('kilometers_go')->default(0)->nullable();
            $table->float('kilometers_return')->default(0)->nullable();
            $table->date('date_work')->nullable();
            $table->time('machine_time')->nullable();
            $table->time('compressor_time')->nullable();
            $table->text('problem_solving')->nullable();
            $table->text('reference')->nullable();
            $table->text('designation')->nullable();
            $table->renameColumn('custom_field_1','customer_observation');
            $table->renameColumn('custom_field_2','supervisor_name');
            $table->renameColumn('custom_field_3','signature');
            $table->renameColumn('custom_field_4','Warranty');
            $table->renameColumn('custom_field_5','Out_Warranty');


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
