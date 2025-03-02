<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jobTypes = ["Contract", "Full Time", "Freelancer", "Part Time"];
        $categories = ["Engineering", "Bookkeeping", "Healthcare", "Arts", "Marketing", "Sales", "Education", "Technology"];
        foreach ($jobTypes as $jobType) {
            JobType::create(['name' => $jobType]);
        }
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
