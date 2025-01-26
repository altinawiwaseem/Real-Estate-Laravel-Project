<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    //
    public function allType()
    {
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type', compact('types'));
    }

    public function addType()
    {
        return view('backend.type.add_type');
    }

    public function storeType(Request $request)
    {

        $request->validate([
            'type_name' => 'required|unique:property_types|max:200|string',
            'type_icon' => 'required|string|max:200',
        ]);

        $typeName = Str::of($request->type_name)->trim()->stripTags();
        $typeIcon = Str::of($request->type_icon)->trim()->stripTags();

        PropertyType::create([
            'type_name' => $typeName,
            'type_icon' => $typeIcon,
        ]);

        $notification = array(
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }

    public function deleteType($id)
    {

        PropertyType::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editType($id)
    {
        $type = PropertyType::findOrFail($id);
        return view('backend.type.edit_type', compact('type'));
    }



    public function updateType(Request $request, $id)
    {

        $type = PropertyType::findOrFail($id);

        $request->validate([
            'type_name' => 'required|max:200|string|unique:property_types,type_name,' . $type->id,

            'type_icon' => 'required|string|max:200',
        ]);

        $typeName = Str::of($request->type_name)->trim()->stripTags();
        $typeIcon = Str::of($request->type_icon)->trim()->stripTags();

        $type->update([
            'type_name' => $typeName,
            'type_icon' => $typeIcon,
        ]);

        $notification = array(
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }
}
