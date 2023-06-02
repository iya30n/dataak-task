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
        Schema::create('news', function (Blueprint $table) {
            $table->id()->index();
            $table->string("title");

            $table->unsignedBigInteger("resource_id");
            // TODO: put the $table->foreign() here.

            $table->string("user_name");
            $table->text("content");
            $table->string("link");
            $table->string("agency_avatar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
