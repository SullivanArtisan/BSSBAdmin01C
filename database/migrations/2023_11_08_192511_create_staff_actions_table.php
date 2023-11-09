<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('staff_id');
            $table->string('staff_action', 255);
            $table->string('staff_action_result', 255)->nullable();
            $table->string('staff_action_severity', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_actions');
    }
}
