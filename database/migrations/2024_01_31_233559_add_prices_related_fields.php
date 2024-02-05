<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesRelatedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_completeds', function (Blueprint $table) {
			$table->decimal('ccntnr_cost', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_surcharges', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_discount', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_tax', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_total', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_net', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_paid', 10, 2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_completeds', function (Blueprint $table) {
            //
        });
    }
}
