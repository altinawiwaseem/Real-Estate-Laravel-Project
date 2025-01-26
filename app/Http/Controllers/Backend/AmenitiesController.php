<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AmenitiesController extends Controller
{
    //

    public function allAmenities()
    {
        $amenities = Amenities::latest()->get();
        return view('backend.amenity.all_amenities', compact('amenities'));
    }


    public function addAmenity()
    {
        return view('backend.amenity.add_amenity');
    }


    public function storeAmenity(Request $request)
    {


        $request->validate([
            'amenity_name' => 'required|unique:amenities,amenities_name|max:200|string',

        ]);

        $amenityName = Str::of($request->amenity_name)->trim()->stripTags();

        Amenities::create([
            'amenities_name' => $amenityName,

        ]);

        $notification = array(
            'message' => 'Amenity Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);
    }


    public function deleteAmenity($id)
    {

        Amenities::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenity Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function editAmenity($id)
    {
        $amenity = Amenities::findOrFail($id);
        return view('backend.amenity.edit_amenity', compact('amenity'));
    }



    public function updateAmenity(Request $request, $id)
    {

        $amenity = Amenities::findOrFail($id);

        $request->validate([
            'amenity_name' => 'required|max:200|string|unique:amenities,amenities_name,' . $amenity->id,
        ]);

        $amenityName = Str::of($request->amenity_name)->trim()->stripTags();


        $amenity->update([
            'amenities_name' => $amenityName,

        ]);

        $notification = array(
            'message' => 'Amenity Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);
    }
}
