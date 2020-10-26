<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_items', function (Blueprint $table) {
            $table->id();
            // I would normally constrain this ID but as we're using sqlite locally, we can't.
            // $table->foreignId('feed_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('feed_id');
            $table->string('title');
            $table->string('link');
            $table->string('description');
            $table->string('publish_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_items');
    }
}
