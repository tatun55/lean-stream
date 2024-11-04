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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('organisation_id')->constrained();
            $table->string('line_user_id',33);
            $table->string('line_display_name',32);
            $table->string('line_picture_url')->nullable();
            $table->string('line_reply_token')->nullable();
            $table->timestamp('line_reply_limit')->nullable();
            $table->string('sei',16)->nullable();
            $table->string('mei',16)->nullable();
            $table->string('phone',11)->nullable();
            $table->string('address')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
