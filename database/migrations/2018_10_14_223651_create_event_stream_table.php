<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_stream', function (Blueprint $table) {
            $table->uuid('event_id');
            $table->uuid('aggregate_root_id');
            $table->timestampTz('created_at');
            $table->string('event_type');
            $table->json('payload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_stream');
    }
}
