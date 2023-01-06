<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('user_id')->nullable();
            $table->string('partner_id')->nullable();
            $table->string('category_id')->nullable();

            $table->text('text')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->tinyInteger('day')->nullable();
            $table->float('bonus')->nullable();
            $table->float('price')->nullable();

            $table->timestamps();

            $table->dateTime('deleted_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
