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
                'name' => 'Dashboard',
                'icon' => 'home',
                'route' => 'backend.dashboard',
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'dashboard',
                'status' => 'Active',
            ],
            // [
            //     'name' => 'Module Make',
            //     'icon' => 'slack',
            //     'route' => 'backend.moduleMaker',
            //     'description' => null,
            //     'sorting' => 1,
            //     'permission_name' => 'module maker',
            //     'status' => 'Active',
            // ],
            [
                'name' => 'User Manage',
                'icon' => 'list',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'user-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'User Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.admin.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'Admin-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'User List',
                        'icon' => 'list',
                        'route' => 'backend.admin.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'Admin-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Permission Manage',
                'icon' => 'unlock',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'permission-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Permission Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.permission.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'permission-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Permission List',
                        'icon' => 'list',
                        'route' => 'backend.permission.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'permission-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Role Manage',
                'icon' => 'layers',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'role-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Role Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.role.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'role-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Role List',
                        'icon' => 'list',
                        'route' => 'backend.role.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'role-list',
                        'status' => 'Active',
                    ],
                ],
            ],


            
    

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