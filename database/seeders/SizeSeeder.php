<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Size::create($value);
        }
    }

    private function datas()
    {
        return [
            // dummy data array will be here

            [
                'name' => 'L'
            ],
            [
                'name' => 'XL'
            ],
            [
                'name' => '38'
            ],
            [
                'name' => '41'
            ],
        ];
    }
}
