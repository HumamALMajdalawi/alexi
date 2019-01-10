<?php

use Illuminate\Database\Seeder;

class ActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $results = \App\Models\Action::truncate();
        $menu = [
            [
                'title' => 'Dashboard',
                'icon' => 'fa fa-tachometer',
                'link' => '/pages/dashboard',
                'is_home' => true,
            ],
                
            [
                'title' => 'Roles',
                'icon' => 'fa fa-lock',
                'link' => '/pages/roles',
            ],

             [
                'title' => 'Company Rates',
                'icon' => 'fa fa-star',
                'link' => '/pages/companyRates',
            ],


             [
                'title' => 'Site Rates',
                'icon' => 'fa fa-star',
                'link' => '/pages/siteRates',
            ],

             [
                'title' => 'Fitter Rates',
                'icon' => 'fa fa-star',
                'link' => '/pages/fitterRates',
            ],

            [
                'title' => 'Developers',
                'icon' => 'fa fa-user',
                'link' => '/pages/developers',
            ],
            [
                'title' => 'Fitters',
                'icon' => 'fa fa-cogs',
                'link' => '/pages/fitters',
            ],
            [
                'title' => 'Sales Sheet',
                'icon' => 'nb-list',
                'link' => '/pages/sales-sheet',
                'children' => [
                    [
                        'title' => 'Sales Sheet',
                        'link' => '/pages/sales-sheet',
                        'is_menu' => true,
                    ],
                    [
                        'title' => 'Add Bulk Sheets',
                        'link' => '/pages/sales-sheet/add',
                        'is_menu' => true,
                    ],
                ],
            ],
               
            [
                'title' => 'Quotations',
                'icon' => 'ion-cash',
                'link' => '/dashboard',
                'children' => [
                    [
                        'title' => 'Quotations',
                        'link' => '/users/list',
                    ],
                    [
                        'title' => 'Create Quotation',
                        'link' => '/users/create',
                        'icon' => 'fa fa-plus',
                    ],
                ],
            ],
            [
                'title' => 'Pricing Matrix',
                'icon' => 'ion-grid',
                'link' => '/dashboard',
                'children' => [
                    [
                        'title' => 'Pricing Matrix',
                        'link' => '/users/list',
                    ],
                    [
                        'title' => 'Create Pricing Matrix',
                        'link' => '/users/create',
                        'icon' => 'fa fa-plus',
                    ],
                ],
            ],
            [
                'title' => 'Diary',
                'icon' => 'ion-calendar',
                'link' => '/dashboard',
            ],
            [
                'title' => 'Branches',
                'icon' => 'fa fa-building-o',
                'link' => '/dashboard',
                'children' => [
                    [
                        'title' => 'Branches',
                        'link' => '/pages/branches',
                    ]
                ],
            ],
            [
                'title' => 'User Management',
                'icon' => 'fa fa-male',
                'link' => '/pages/users',
                'children' => [
                    [
                        'title' => 'General Users',
                        'link' => '/pages/users/general-users',
                    ],
                    [
                        'title' => 'General Admins',
                        'link' => '/pages/users/general-admins',
                    ],
                    [
                        'title' => 'Branch Admins',
                        'link' => '/pages/users/branch-admins',
                    ],
                    [
                        'title' => 'Branch Staff',
                        'link' => '/pages/users/branch-staff',
                    ],
//                    [
//                        'title' => 'Contract Managers',
//                        'link' => '/users/list',
//                    ],
//                    [
//                        'title' => 'Fitters',
//                        'link' => '/users/list',
//                    ],
                ],
            ],
            [
                'title' => 'Jobs',
                'icon' => 'fa fa-male',
                'link' => '/pages/jobs',
            ],
        ];
        $crud = [['title' => 'view'], ['title' => 'add'], ['title' => 'delete'], ['title' => 'update']];
        foreach ($menu as $action) {
            $action['is_menu'] = true;
            $action['group_name'] = $action['title'];
            $action['title'] = null;
            $children = [];
            if (isset($action['children'])) {
                $children = $action['children'];
                unset($action['children']);
            }
            $action = \App\Models\Action::create($action);
            if (!empty($children)) {
                foreach ($children as $child) {
                    $child['menu_parent_id'] = $action['id'];
                    $child['parent_id'] = $action['id'];
                    $child['is_menu'] = true;
                    $child = \App\Models\Action::create($child);
                    foreach ($crud as $c) {
                        $c['parent_id'] = $child['id'];
                        if ($c['title'] != 'view')
                            $c['route'] = str_replace(' ', '_', strtolower($child['title'])) . '_' . $c['title'];
                        \App\Models\Action::create($c);
                    }
                }
            } else {
                foreach ($crud as $c) {
                    $c['parent_id'] = $action['id'];
                    if ($c['title'] != 'view')
                        $c['route'] = str_replace(' ', '_', strtolower($action['group_name'])) . '_' . $c['title'];
                    \App\Models\Action::create($c);
                }
            }
        }
    }
}
