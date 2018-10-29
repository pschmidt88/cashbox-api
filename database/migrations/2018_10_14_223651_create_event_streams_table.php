<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_streams', function (Blueprint $table) {
            $table->bigInteger('no')->autoIncrement();
            $table->string('real_stream_name', 150);
            $table->char('stream_name', 41);
            $table->longText('metadata');
            $table->string('category', 150);

            $table->unique('real_stream_name', 'ix_rsn');
            $table->index('category', 'ix_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_streams');
    }
}
