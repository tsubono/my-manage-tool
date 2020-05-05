<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->string('color')->comment('色');
        });

        DB::table('sale_statuses')->insert([
                [
                    'name' => '仮確定',
                    'color' => '#7A9E9F',
                ],
                [
                    'name' => '確定',
                    'color' => '#EB5E28',
                ],
                [
                    'name' => '請求書送付済み',
                    'color' => '#F3BB45',
                ],
                [
                    'name' => '入金済み',
                    'color' => '#41B883',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_statuses');
    }
}
