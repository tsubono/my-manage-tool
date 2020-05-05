<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('label_id')->comment('ラベルID');
            $table->foreign('label_id')->references('id')->on('labels')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->comment('プロジェクトID');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_project');
    }
}
