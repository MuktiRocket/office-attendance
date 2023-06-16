<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnNamesLatitudeAndLongitudeInEmployeeAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_attendance', function (Blueprint $table) {
            $table->renameColumn('latitude', 'in_latitude');
            $table->renameColumn('longitude', 'in_longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_attendance', function (Blueprint $table) {
            $table->renameColumn('in_latitude', 'latitude');
            $table->renameColumn('in_longitude', 'longitude');
        });
    }
}
