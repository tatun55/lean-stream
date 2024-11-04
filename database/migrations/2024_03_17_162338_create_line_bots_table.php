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
        Schema::create('line_bots', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('organisation_id')->constrained()->unique();
            $table->string('destination', 33)->unique();
            $table->string('basic_id',);
            $table->string('channel_secret', 32);
            $table->string('access_token', 172);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_bots');
    }
};
