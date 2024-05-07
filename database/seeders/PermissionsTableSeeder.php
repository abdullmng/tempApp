<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //enrollees
            'can_view_enrollees',
            'can_create_enrollees',
            'can_edit_enrollees',
            'can_delete_enrollees',
            'can_bulk_import_enrollees',
            'can_print_enrollee_slip',
            'can_print_enrollee_id_card',
            'can_export_raw',
            'can_import_raw',
            //branches
            'can_view_branches',
            'can_create_branches',
            'can_edit_branches',
            'can_delete_branches',
            //sectors
            'can_view_sectors',
            'can_create_sectors',
            'can_edit_sectors',
            'can_delete_sectors',
            //categories
            'can_view_categories',
            'can_create_categories',
            'can_edit_categories',
            'can_delete_categories',
            //organisations
            'can_view_organisations',
            'can_create_organisations',
            'can_edit_organisations',
            'can_delete_organisations',
            //hcps
            'can_view_hcps',
            'can_create_hcps',
            'can_edit_hcps',
            'can_delete_hcps',
            //users
            'can_view_users',
            'can_create_users',
            'can_edit_users',
            'can_delete_users',
            'can_grant_permissions',
            //reports
            'can_view_reports',
            'can_export_reports',
            //roles
            'can_view_roles',
            'can_create_roles',
            'can_edit_roles',
            'can_delete_roles'
        ];

        $data = [];
        foreach ($permissions as $permission) {
            $data[] = ['name' => $permission, 'guard_name' => 'web', 'created_at' => now(),'updated_at'=> now()];
        }

        DB::table('permissions')->insert($data);
    }
}
