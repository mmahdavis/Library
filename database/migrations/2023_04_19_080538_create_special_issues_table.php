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
        Schema::create('special_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('tag_id')->nullable()->constrained('tags')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->integer('price')->default(0);
            $table->string('cover_type')->nullable();
            $table->string('paper_type')->nullable();
            $table->string('publication_year')->nullable();
            $table->string('publication_month')->nullable();
            $table->integer('page')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_issues');
    }
};
