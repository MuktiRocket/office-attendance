<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnNameProfileImageAndAddNewColumnOutImageInEmployeeAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_attendance', function (Blueprint $table) {
            $table->renameColumn('profile_image', 'in_profile_image');
            $table->string('out_profile_image', 255)->nullable();
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
            $table->renameColumn('in_profile_image', 'profile_image');
            $table->dropColumn('out_profile_image');
        });
    }
}
