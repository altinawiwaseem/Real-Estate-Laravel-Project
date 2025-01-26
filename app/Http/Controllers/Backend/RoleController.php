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

        /* $fileFullPath = storage_path('app/private' . $filePath);

         logger('Uploaded file path: ' . storage_path('app/' . $filePath));
        dump(storage_path('app/' . $filePath));

        // Check if the file exists
        if (!file_exists($fileFullPath)) {
            dd('File not found: ' . $fileFullPath);
        } */

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
}
