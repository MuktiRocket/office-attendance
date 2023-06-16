<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnAttendanceGivenInEmployeeAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_attendance', function (Blueprint $table) {
            $table->enum('attendance_given',['SIGNED IN','SIGNED OUT'])->default('SIGNED IN');
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
            $table->dropColumn('attendance_given');
        });
    }
}
