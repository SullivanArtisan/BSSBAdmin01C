<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCntnrInfoFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_completeds', function (Blueprint $table) {
			$table->string('ccntnr_status', 23);
			$table->string('ccntnr_cstm_account_name', 127);
            $table->datetime('ccntnr_cntnr_completed_on')->useCurrent()->useCurrentOnUpdate();
			$table->string('ccntnr_size', 40)->nullable();
			$table->string('ccntnr_goods_desc', 127)->nullable();
			$table->date('ccntnr_ssl_release_date')->nullable();
			$table->string('ccntnr_cstm_order_no', 15)->nullable();
			$table->date('ccntnr_cstm_release_date')->nullable();
			$table->time('ccntnr_cstm_release_time')->nullable();
			$table->date('ccntnr_trmnl_lfd')->nullable();
			$table->date('ccntnr_ssl_lfd')->nullable();
			$table->date('ccntnr_mt_lfd')->nullable();
			$table->string('ccntnr_mt_release_no', 15)->nullable();
			$table->string('ccntnr_empty_return_trmnl', 127)->nullable();
			$table->string('ccntnr_ssl', 63);
			$table->string('ccntnr_type', 15)->nullable()->default('Shipping');
			$table->string('ccntnr_length', 7)->nullable()->default('40');
			$table->decimal('ccntnr_max_load', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_max_weight', 10, 2)->nullable()->default(0);
			$table->decimal('ccntnr_tare_weight', 10, 2)->nullable()->default(0);
			$table->string('ccntnr_seal_no', 30)->nullable();
			$table->string('ccntnr_dvr_no', 15)->nullable();
			$table->string('ccntnr_pwr_unit_no_1', 15)->nullable();
			$table->string('ccntnr_pwr_unit_no_2', 15)->nullable();
			$table->decimal('ccntnr_cargo_weight', 10, 2)->nullable()->default(0);
			$table->tinyInteger('ccntnr_weight_unit')->nullable()->default(0);
			$table->string('ccntnr_invoice', 31)->nullable();
			$table->string('ccntnr_chassis_id', 10)->nullable();
			$table->string('ccntnr_chassis_type', 30)->nullable();
			$table->string('ccntnr_droponly', 1)->nullable();
            $table->mediumText('ccntnr_remarks')->nullable();
            $table->mediumText('ccntnr_dispatcher_notes')->nullable();
            $table->mediumText('ccntnr_driver_notes')->nullable();
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
