<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('client_id')->comment('取引先ID')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('set null');
            $table->string('name')->comment('名称');
            $table->text('content')->nullable()->comment('内容');
            $table->date('start_date')->nullable()->comment('開始日');
            $table->date('limit_date')->nullable()->comment('納期');
            $table->unsignedBigInteger('status_id')->comment('ステータスID')->nullable();
            $table->foreign('status_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('projects');
    }
}
