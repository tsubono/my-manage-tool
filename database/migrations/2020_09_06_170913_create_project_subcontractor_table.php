<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSubcontractorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_subcontractor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->comment('案件ID');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('subcontractor_id')->comment('外注先ID');
            $table->foreign('subcontractor_id')->references('id')->on('subcontractors')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('price')->nullable()->comment('外注金額');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_subcontractor');
    }
}
