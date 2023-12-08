<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('inv_serial_no', 23);
			$table->string('inv_job_no', 15);
			$table->decimal('inv_total', 10, 2);
			$table->decimal('inv_paid', 10, 2)->nullable()->default(0);
			$table->string('inv_status', 23);
			$table->date('inv_issued_date');
			$table->date('inv_due_date');
			$table->string('inv_notes', 63)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
