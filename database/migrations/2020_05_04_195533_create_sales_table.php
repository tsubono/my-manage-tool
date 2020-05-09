<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->unsignedBigInteger('project_id')->comment('案件ID')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->date('planned_deposit_date')->comment('入金予定日')->nullable();
            $table->date('deposit_date')->comment('入金日')->nullable();
            $table->integer('price')->comment('金額')->nullable();
            $table->unsignedBigInteger('sale_status_id')->comment('売上ステータスID');
            $table->foreign('sale_status_id')->references('id')->on('sale_statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->text('note')->nullable()->comment('備考');
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
        Schema::dropIfExists('sales');
    }
}
