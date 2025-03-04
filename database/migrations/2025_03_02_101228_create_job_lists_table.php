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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("status")->default(1);
            $table->timestamps();
        });

        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("status")->default(1);
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });

        Schema::create('job_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('vacancy');
            $table->string('salary')->nullable();
            $table->string('location')->nullable();
            $table->longText('description');
            $table->mediumText('benefits')->nullable();
            $table->mediumText('responsiblity')->nullable();
            $table->mediumText('qualifications')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->integer('experience');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment("Job posted by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_lists');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('categories');
    }
};
