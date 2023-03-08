<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');
            $table->string('name');
            $table->string('email');
            $table->integer('age');
            $table->string('gender');
            $table->integer('phone');
            $table->integer('test_id');
            $table->string('test_name');
            $table->float('total', 8, 2);
            $table->float('advance', 8, 2);
            $table->float('due', 8, 2);
            $table->boolean('status');
            $table->boolean('report_status');
            $table->string('role');
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
        Schema::dropIfExists('patients');
    }
}
