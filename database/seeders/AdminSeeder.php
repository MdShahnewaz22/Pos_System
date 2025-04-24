<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([

            'first_name' => 'Mohammad',
            'last_name' => 'Shahnewaz ',
            'email' => 'mdshahnewazs77@gmail.com',
            'phone' => '01785915418',
            'password' =>'abc123',
        ]);
        
    }
    
}
