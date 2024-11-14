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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('original_url');
            $table->string('short_code')->unique();
            $table->dateTime('expire_at')->nullable();
            $table->unsignedInteger('visit_count')->default(0);
            $table->dateTime('last_visited_at')->nullable();
            $table->timestamps();

            // Indexing for optimization
            $table->index(['short_code', 'expire_at', 'visit_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
