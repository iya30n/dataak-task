<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twitters', function (Blueprint $table) {
            $table->id()->index();
            $table->text('content');
            $table->string("user_name");
            $table->unsignedBigInteger("resource_id");
            $table->string('retweet_count');
            $table->string('image');
            $table->text("user_avatar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitters');
    }
};
