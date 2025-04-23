<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Color::create($value);
        }
    }

    private function datas()
    {
        return [
            // dummy data array will be here
            [
                'name'=>'Red'
            ],
            [
                'name'=>'Blue'
            ]
        ];
    }
}
