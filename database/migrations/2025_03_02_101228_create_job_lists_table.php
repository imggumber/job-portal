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
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });

        Schema::create('job_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status', length: 200);
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

        Schema::create('jobs_list_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_lists')->onDelete('cascade');
            $table->foreignId('job_status_id')->constrained('job_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->id();
            $table->date('applied_on');
            $table->foreignId('job_status_id')->constrained('job_statuses')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_lists')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_jobs');
        Schema::dropIfExists('jobs_list_statuses');
        Schema::dropIfExists('job_lists');
        Schema::dropIfExists('job_statuses');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('categories');
    }
};
