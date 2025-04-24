<?php

namespace Database\Seeders;

use App\Models\Menu; // Correct import
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            $this->createMenu($value);
        }
    }

    private function createMenu($data, $parent_id = null)
    {
        $menu = new Menu([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'route' => $data['route'],
            'description' => $data['description'],
            'sorting' => $data['sorting'],
            'parent_id' => $parent_id,
            'permission_name' => $data['permission_name'],
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        $menu->save();

        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $child) {
                $this->createMenu($child, $menu->id);
            }
        }
    }

    private function datas()
    {
        return [
           
    [
        "name" => "Product Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Product-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Product Add",
                "icon" => "plus-circle",
                "route" => "backend.product.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Product List",
                "icon" => "list",
                "route" => "backend.product.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],
    [
        "name" => "Color Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Color-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Color Add",
                "icon" => "plus-circle",
                "route" => "backend.color.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Color List",
                "icon" => "list",
                "route" => "backend.color.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],
    [
        "name" => "Size Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Size-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Size Add",
                "icon" => "plus-circle",
                "route" => "backend.size.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Size List",
                "icon" => "list",
                "route" => "backend.size.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],

    [
        "name" => "Unit Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Unit-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Unit Add",
                "icon" => "plus-circle",
                "route" => "backend.unit.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Unit List",
                "icon" => "list",
                "route" => "backend.unit.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],
    [
        "name" => "Product Detail Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Productdetail-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Product detail Add",
                "icon" => "plus-circle",
                "route" => "backend.productdetail.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Product detail List",
                "icon" => "list",
                "route" => "backend.productdetail.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],
    [
        "name" => "Shipping Detail Manage",
        "icon" => "aperture",
        "route" => null,
        "description" => null,
        "sorting" => 1,
        "permission_name" => "Productdetail-management",
        "status" => "Active",
        "children" => [
            [
                "name" => "Shipping details Add",
                "icon" => "plus-circle",
                "route" => "backend.shippingdetail.create",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-add",
                "status" => "Active",
            ],
            [
                "name" => "Shipping details List",
                "icon" => "list",
                "route" => "backend.shippingdetail.index",
                "description" => null,
                "sorting" => 1,
                "permission_name" => "role-list",
                "status" => "Active",
            ],
        ],
    ],

    //don't remove this comment from menu seeder
        ];
    }
}