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
            $table->integer('company_id');
            $table->integer('worker_id');
            $table->timestamp('scheduled');
            $table->integer('status'); //0-offer, 1-accept, 2-reject
            $table->integer('worker_delete');
            $table->integer('company_delete');
            $table->integer('reject_offer_by'); //1 businessman, 2 worker
            $table->integer('reject_user_id');
            $table->string('reject_reason');
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
