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
        Schema::create('instagrams', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title');

            $table->unsignedBigInteger("resource_id");

            //TODO: move these galleries to a specific table
            $table->text('images_gallery');
            $table->text('video_gallery');

            $table->text("content");
            $table->string("user_name");
            $table->text("user_avatar");
            $table->text("user_username");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagrams');
    }
};
