<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render("access.index");
    }

    public function createRoles()
    {
        $permissions = Permission::all();
        return view('access.create_roles', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'permissions' => 'required'], ['permissions' => 'You must check at least one permission']);
        $permissions = $request->permissions;

        if (is_array($permissions)) {
            $role = Role::create(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $permissions)->get();
            //dd($permissions);
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        return back()->with('success','Role created successfully');
    }

    public function showRole($id)
    {
        $role = Role::where('id', $id)->first();
        $permissions = Permission::all();
        return view('access.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function updateRole($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', 'permissions' => 'required'], ['permissions' => 'You must check at least one permission']);
        $permissions = $request->permissions;
        if (is_array($permissions)) {
            $role = Role::where('id', $id)->first();
            $rolePermissions = [];
            $role->permissions->each(function ($permission) use (&$rolePermissions) {
                $rolePermissions[] = $permission->name;
            });
            $permissions = Permission::whereIn('id', $permissions)->get();
            $newPermissions = [];
            $permissions->each(function ($permission) use (&$newPermissions) {
                $newPermissions[] = $permission->name;
            });
            //dd($rolePermissions, $newPermissions);
            $permissionsToRevoke = array_diff($rolePermissions, $newPermissions);
            foreach ($permissionsToRevoke as $permissionToRevoke)
            {
                if ($role->hasPermissionTo($permissionToRevoke))
                {
                    $role->revokePermissionTo($permissionToRevoke);
                }
            }
            //dd($permissions);
            foreach ($permissions as $permission) {
                if (!$role->hasPermissionTo($permission->name))
                {
                    $role->givePermissionTo($permission);
                }
            }
        }
        return back()->with('success','Role updated successfully');
    }

    public function deleteRole($id)
    {
        Role::where('id', $id)->delete();
        return back()->with('success','Role deleted');
    }
}
