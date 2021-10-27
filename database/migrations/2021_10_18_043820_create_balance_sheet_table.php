<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeStatementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheet', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_title');
            $table->boolean('is_total');
            $table->boolean('is_sub_total');
            $table->boolean('is_separator');
            $table->decimal('data', 16, 2)->nullable();
            $table->integer('order');
            $table->unsignedBigInteger('catalog_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('period_id')->nullable();
            $table->timestamps();

            $table->foreign('account_id')
            ->references('id')
            ->on('account')
            ->onDelete('cascade');

            $table->foreign('company_id')
            ->references('id')
            ->on('company')
            ->onDelete('cascade');

            $table->foreign('catalog_id')
            ->references('id')
            ->on('catalog')
            ->onDelete('cascade');

            $table->foreign('period_id')
            ->references('id')
            ->on('periods')
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
        Schema::dropIfExists('income_statement');
    }
}
