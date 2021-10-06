<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->integer('account')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('parent')->nullable();
            $table->unsignedBigInteger('catalog_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();

            $table->foreign('catalog_id')
            ->references('id')
            ->on('catalog')
            ->onDelete('cascade');

            $table->foreign('company_id')
            ->references('id')
            ->on('company')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
