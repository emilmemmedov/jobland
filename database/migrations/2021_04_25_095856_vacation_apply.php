<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VacationApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_apply', function (Blueprint $table) {
            $table->id();
            $table->integer('vacation_id');
            $table->integer('company_id');
            $table->integer('worker_id');
            $table->integer('worker_delete');
            $table->integer('company_delete');
            $table->integer('status'); //0-apply, 1-accept, 2-reject
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
        Schema::dropIfExists('vacation_apply');
    }
}
