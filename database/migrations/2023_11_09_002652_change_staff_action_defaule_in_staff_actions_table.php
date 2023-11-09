<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStaffActionDefauleInStaffActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_actions', function (Blueprint $table) {
            $table->string('staff_action', 255)->default('0')->change();
            $table->string('staff_action_result', 255)->nullable()->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_actions', function (Blueprint $table) {
            //
        });
    }
}
