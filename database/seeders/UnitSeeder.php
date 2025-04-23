<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Unit::create($value);
        }
    }

    private function datas()
    {
        return [
            // dummy data array will be here
            [
                'name' => 'kg'
            ],
            [
                'name' => 'litter'
            ],
            [
                'name' => 'pieces'
            ],

        ];
    }
}
