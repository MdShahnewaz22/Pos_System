<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SalaryAllowanceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        $this->call([
            MenuSeeder::class,
            
          
            AdminSeeder::class,
            ProductSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            UnitSeeder::class,
            ProductdetailSeeder::class,
          
        ]);
    }
}
