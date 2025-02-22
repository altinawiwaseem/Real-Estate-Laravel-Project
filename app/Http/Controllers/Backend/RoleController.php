<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionsExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Str;

class RoleController extends Controller
{
    //
    public function allPermission()
    {

        $permission = Permission::all();

        return view('backend.pages.permission.all_permission', compact('permission'));
    }

    public function addPermission()
    {
        return view('backend.pages.permission.add_permission');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|max:200|string|unique:permissions,name,' . $request->id,
            'group_name' => 'required|max:200|string',
        ]);

        $name = Str::of($request->permission_name)->trim()->stripTags();
        $group_name = Str::of($request->group_name)->trim()->stripTags();

        Permission::create([
            'name' => $name,
            'group_name' => $group_name,
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function deletePermission($id)
    {

        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }



    public function updatePermission(Request $request, $id)
    {

        $permission = Permission::findOrFail($id);

        $request->validate([
            'permission_name' => 'required|max:200|string|unique:permissions,name,' . $id,
            'group_name' => 'required|max:200|string',
        ]);

        $name = Str::of($request->permission_name)->trim()->stripTags();
        $group_name = Str::of($request->group_name)->trim()->stripTags();

        $permission->update([
            'name' => $name,
            'group_name' => $group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function importPermission()
    {
        return view('backend.pages.permission.import_permission');
    }

    // Wxport Permission to Excel
    public function exportPermissions()
    {
        $filename = PermissionsExport::exportToExcel();

        return response()->download(storage_path("app/public/{$filename}"))->deleteFileAfterSend();
    }

    // Import Permission from Excel
    public function importPermissions(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls'
        ]);

        // Store the uploaded file in a temporary location
        $file = $request->file('import_file');

        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        // Import the data from the Excel file
        PermissionsImport::importFromExcel(storage_path('app/private/' . $filePath));

        // Delete the temporary file
        Storage::delete($filePath);

        $notification = array(
            'message' => 'Permissions imported successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    // Role Methods

    public function allRoles()
    {
        $roles = Role::all();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function addRole()
    {
        return view('backend.pages.roles.add_role');
    }

    public function storeRole(Request $request)
    {

        $request->validate([
            'role_name' => 'required|max:200|string|unique:roles,name,' . $request->id
        ]);

        $name = Str::of($request->role_name)->trim()->stripTags();

        Role::create([
            'name' => $name
        ]);

        $notification = array(
            'message' => "Role Created Successfully",
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function deleteRole($id)
    {

        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => "Role Deleted Successfully",
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editRole($id)
    {

        $role = Role::findOrFail($id);
        return view('backend.pages.roles.edit_role', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {

        $role = Role::findOrFail($id);


        $request->validate([
            'role_name' => 'required|max:200|string|unique:roles,name,' . $id
        ]);

        $name = Str::of($request->role_name)->trim()->stripTags();

        $role->update([
            'name' => $name
        ]);

        $notification = array(
            'message' => "Role Updated Successfully",
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }
}
