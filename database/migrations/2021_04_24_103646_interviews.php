<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Interviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('language');
            $table->timestamp('scheduled');
            $table->integer('company_id');
            $table->integer('worker_id');
            $table->string('vacation_id');
            $table->integer('status_id');
            /*
                1 - created by company
                2 - accepted by worker
                3 - rejected by worker
                4 - canceled by company
                5 - accept worker for vacation
                6 - reject worker for vacation
             */
            $table->string('reject_vacation_reason');
            $table->string('reject_worker_reason');
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
        Schema::dropIfExists('interviews');
    }
}
