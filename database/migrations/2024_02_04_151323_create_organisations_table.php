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
        Schema::create('organisations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['company', 'manshion_union', 'other']);
            $table->string('name', 32);
            $table->string('avatar', 1024)->default('img/organisation.png');
            $table->string('url', 1024)->nullable();
            $table->string('postal_code', 7)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('tel', 15)->nullable();
            $table->string('note', 1024)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
