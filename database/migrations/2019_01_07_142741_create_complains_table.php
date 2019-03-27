<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_type');
            $table->string('complain_to');
            $table->string('related_for');
            $table->longText('message');
            $table->string('user_id');
            $table->string('name');
            $table->string('status');
            $table->string('closed_by');
            $table->longText('resolution');
            $table->string('is_deleted');
            $table->string('deleted_by');
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
        Schema::dropIfExists('complains');
    }
}
