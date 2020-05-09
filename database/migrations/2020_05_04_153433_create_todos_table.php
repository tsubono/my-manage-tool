<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('parent_todo_id')->comment('親todoID')->nullable();
            $table->string('title')->comment('タイトル');
            $table->longText('content')->comment('内容')->nullable();
            $table->dateTimeTz('limit_datetime')->comment('期限')->nullable();
            $table->boolean('status')->comment('完了ステータス')->default(false);
            $table->integer('sort')->comment('順番')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
