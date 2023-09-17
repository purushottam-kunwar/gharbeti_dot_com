<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fiscal_year', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->string('bs_start_date')->nullable();
            $table->string('bs_end_date')->nullable();
            $table->string('ad_start_date')->nullable();
            $table->string('ad_end_date')->nullable();
            $table->enum('status', ['active', 'deactivate'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_year');
    }
};
