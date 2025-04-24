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
                'unit_value' => '50',
                'color_id' => '1',
                'size_id' =>'1',
                'purchase_price' =>'1000',
                'selling_price' =>'1400',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'1400',
                'image' =>'productdetail/TShirt1.jpeg'
            ],
            [
                'product_id' => '1',
                'unit_id' => '2',
                'unit_value' => '28',
                'color_id' => '2',
                'size_id' =>'2',
                'purchase_price' =>'800',
                'selling_price' =>'1100',
                'tax' =>'5',
                'discount' =>'8',
                'total_price' =>'1062.60',
                'image' =>'productdetail/T-Shirt2.jpeg'
            ],
            [
                'product_id' => '1',
                'unit_id' => '3',
                'unit_value' => '35',
                'color_id' => '1',
                'size_id' =>'1',
                'purchase_price' =>'1000',
                'selling_price' =>'1400',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'1400',
                'image' =>'productdetail/TShirt3.jpeg'
            ],
            [
                'product_id' => '1',
                'unit_id' => '2',
                'unit_value' => '48',
                'color_id' => '2',
                'size_id' =>'2',
                'purchase_price' =>'800',
                'selling_price' =>'1100',
                'tax' =>'5',
                'discount' =>'8',
                'total_price' =>'1062.60',
                'image' =>'productdetail/T-Shirt4.jpeg'
            ],

            [
                'product_id' => '2',
                'unit_id' => '3',
                'unit_value' => '55',
                'color_id' => '1',
                'size_id' =>'3',
                'purchase_price' =>'2000',
                'selling_price' =>'2800',
                'tax' =>'5',
                'discount' =>'10',
                'total_price' =>'2646.00',
                'image' =>'productdetail/Shoe1.jpeg'
            ],
            [
                'product_id' => '2',
                'unit_id' => '3',
                'unit_value' => '62',
                'color_id' => '2',
                'size_id' =>'4',
                'purchase_price' =>'1500',
                'selling_price' =>'2150',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'2150',
                'image' =>'productdetail/Shoe2.jpeg'
            ],

            [
                'product_id' => '2',
                'unit_id' => '3',
                'unit_value' => '29',
                'color_id' => '1',
                'size_id' =>'3',
                'purchase_price' =>'2000',
                'selling_price' =>'2800',
                'tax' =>'5',
                'discount' =>'10',
                'total_price' =>'2646.00',
                'image' =>'productdetail/Shoe3.jpeg'
            ],

            [
                'product_id' => '2',
                'unit_id' => '3',
                'unit_value' => '40',
                'color_id' => '2',
                'size_id' =>'4',
                'purchase_price' =>'2000',
                'selling_price' =>'2200',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'2200',
                'image' =>'productdetail/Shoe4.jpeg'
            ],
           

            [
                'product_id' => '3',
                'unit_id' => '1',
                'unit_value' => '50',
                'purchase_price' =>'80',
                'selling_price' =>'100',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'100',
                'image' =>'productdetail/Sugar1.jpeg'
            ],
            [
                'product_id' => '3',
                'unit_id' => '1',
                'unit_value' => '18',
                'purchase_price' =>'80',
                'selling_price' =>'120',
                'tax' =>'0',
                'discount' =>'0',
                'total_price' =>'130',
                'image' =>'productdetail/Sugar1.jpeg'
            ],
            [
                'product_id' => '3',
                'unit_id' => '1',
                'unit_value' => '34',
                'purchase_price' =>'100',
                'selling_price' =>'125',
                'tax' =>'0',
                'discount' =>'5',
                'total_price' =>'125',
                'image' =>'productdetail/Sugar2.jpeg'
            ],
        ];
    }
}
