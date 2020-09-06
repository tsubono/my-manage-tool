<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelSubcontractorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_subcontractor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('label_id')->comment('ラベルID');
            $table->foreign('label_id')->references('id')->on('labels')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('subcontractor_id')->comment('外注先ID');
            $table->foreign('subcontractor_id')->references('id')->on('subcontractors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_subcontractor');
    }
}
