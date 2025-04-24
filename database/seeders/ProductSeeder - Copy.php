<?php

namespace Database\Seeders;

use App\Models\Productdetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Productdetail::create($value);
        }
    }

    private function datas()
    {
        return [
            // dummy data array will be here
            [
                'product_id' => '1',
                'unit_id' => '3',
                'unit_value' => '2',
                'color_id' => '1',
                'size_id' =>'1',
                'purchase_price' =>'1000',
                'selling_price' =>'1400',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'1400',
                'image' =>'judge/p1.WEBP'
            ],
        ];
    }
}
