<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function AllFeature()
    {
        $feature = Feature::latest()->get();
        return view('admin.backend.feature.all_feature',compact('feature'));
    }

    public function AddFeature()
    {
        return view('admin.backend.feature.add_feature');
    }

    public function StoreFeature(Request $request)
    {
            Feature::create([
                'title' => $request->title,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' =>  'Feature Inserted successfully',
                'alert_type' => 'success',
            );
            return redirect()->route('all.feature')->with($notification);
    }

    public function EditFeature($id)
    {
        $feature = Feature::find($id);
        return view('admin.backend.feature.edit_feature',compact('feature'));
    }


    public function UpdateFeature(Request $request)
    {
            $feature_id = $request->id;

            Feature::find($feature_id)->update([
                'title' => $request->title,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' =>  'Feature Updated successfully',
                'alert_type' => 'success',
            );
            return redirect()->route('all.feature')->with($notification);
    }

    public function DeleteFeature($id)
    {

        Feature::find($id)->delete();

        $notification = array(
                'message' =>  'Feature Deleted successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
    }
}
