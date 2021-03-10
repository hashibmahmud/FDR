<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFDRTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_d_r_tables', function (Blueprint $table) {
            $table->id();
            $table->string('fdr_number')->unique();
            $table->string('bank_name');
            $table->string('branch_name');
            $table->integer('opening_amount');
            $table->date('opening_date');
            $table->integer('period');
            $table->date('next_maturity');
            $table->double('interest');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('status');
            $table->string('creator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('f_d_r_tables');
    }
}
