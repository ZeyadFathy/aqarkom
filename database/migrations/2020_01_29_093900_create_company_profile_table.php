<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description');
            $table->integer('category_id');
            $table->integer('city_id');
            $table->string('contact_number');
            $table->string('email');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('twitter');
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->string('csr');
            $table->integer('status')->default(-1);
            $table->integer('featured')->default(-1);
            $table->string('location')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
