<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Product::create($value);
        }
    }

    private function datas()
    {
        return [
            // dummy data array will be here
            [
                'name' => 'T-Shirt',
                'sku' => 'a1b2',
            ],
            [
                'name' => 'Shoe',
                'sku' => 'ab12c',
            ],
            [
                'name' => 'Sugar',
                'sku' => 'ab1d2c',
            ],
        ];
    }
}
