<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeStatementConfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_statement_conf', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('catalog_id')->nullable();
            $table->unsignedBigInteger('group')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_statement_conf');
    }
}
