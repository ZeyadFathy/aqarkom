<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionInCompaniesPortfolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_portfolio', function (Blueprint $table) {
            //
            $table->text('description_en')->after('title_en');
            $table->text('description_ar')->after('description_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_portfolio', function (Blueprint $table) {
            //
        });
    }
}
