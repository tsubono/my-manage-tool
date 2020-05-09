<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->string('name')->comment('名前');
            $table->string('address')->comment('住所')->nullable();
            $table->text('note')->nullable()->comment('備考');
            $table->string('url')->nullable()->comment('会社url');
            $table->date('contract_date')->nullable()->comment('契約日');
            $table->string('icon_path')->nullable()->comment('アイコンパス');
            $table->boolean('status')->default(true)->comment('ステータス: 有効 / 無効');
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
        Schema::dropIfExists('clients');
    }
}
