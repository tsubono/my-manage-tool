<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->comment('プロジェクトID');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTimeTz('start_at')->comment('開始日時');
            $table->dateTimeTz('end_at')->comment('終了日時')->nullable();
            $table->text('content')->comment('内容')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_records');
    }
}
