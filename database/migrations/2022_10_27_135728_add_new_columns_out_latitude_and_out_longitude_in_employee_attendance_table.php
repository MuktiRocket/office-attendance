<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsOutLatitudeAndOutLongitudeInEmployeeAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_attendance', function (Blueprint $table) {
            $table->string('out_latitude', 50)->nullable();
            $table->string('out_longitude', 50)->nullable();
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
            $table->dropColumn('out_latitude');
            $table->dropColumn('out_longitude');
        });
    }
}
