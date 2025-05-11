<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'account_settings',
            'profile',
            'change-password',
            'role-permission',
            'user-roll-permission',
            'order-list',
            'login-info',
            'expense-delete',
            'expense-edit',
            'expense-list',
            'userBehave-module',
            'expense-create',
            'expense-category',
            'expense-module',
            'order-payment-sheet',
            'order-courier-sheet',
            'order-delete',
            'order-payment',
            'order-change',
            'order-edit',
            'order-create',
            'order-module',
            'product-transfer',
            'product-show',
            'product-edit',
            'product-delete',
            'product-add',
            'product-module',
            'setting-module',
            'admin-edit',
            'admin-add',
            'admin-module',
            'wholesaler-order',
            'wholesaler-pos',
            'wholesaler-transaction',
            'wholesaler-payment',
            'wholesaler-show',
            'wholesaler-list',
            'wholesaler-edit',
            'wholesaler-add',
            'wholesaler-module',
            'supplier-order',
            'stock-add',
            'supplier-module',
            'supplier-delete',
            'supplier-transaction',
            'supplier-payment',
            'supplier-account',
            'supplier-list',
            'supplier-edit',
            'supplier-create',
            'wholesaler-delete',
            'supplier-return,',
            'product-history',
            'expense-category-delete'

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
