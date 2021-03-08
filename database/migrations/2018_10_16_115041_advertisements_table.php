<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('details');
            $table->integer('user_id');
            $table->integer('category_id');
	        $table->string('images')->nullable();
            $table->integer('status')->default(-1);
            $table->integer('featured')->default(-1);
            $table->integer('area')->nullable();
            $table->integer('price')->nullable();
            $table->double('ad_long');
            $table->double('ad_lat');
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
        Schema::dropIfExists('advertisements');
    }
}
