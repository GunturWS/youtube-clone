<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('channel_id');
            $table->string('channel_name');
            $table->string('channel_thumbnail')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'channel_id']); // Prevent duplicate subscriptions
            $table->index('channel_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};