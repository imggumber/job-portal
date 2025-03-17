<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'),
        ]);

        $jobTypes = ["Contract", "Full Time", "Freelancer", "Part Time"];
        $categories = ["Engineering", "Bookkeeping", "Healthcare", "Arts", "Marketing", "Sales", "Education", "Technology"];
        $jobStatues = ["Active", "Pending", "Expired"];
        foreach ($jobTypes as $jobType) {
            JobType::create(['name' => $jobType]);
        }
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
        foreach($jobStatues as $jobStatus){
            DB::beginTransaction();
            DB::table("job_statuses")->insert(['status' => $jobStatus, 'created_at' => now(), 'updated_at' => now()]);
            DB::commit();
        }
    }
}
