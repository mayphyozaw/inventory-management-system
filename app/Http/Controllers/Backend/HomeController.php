<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Clarify;
use App\Models\Feature;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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


    public function GetClarifies()
    {
        $clarify = Clarify::find(1);
        return view('admin.backend.clarify.get_clarify', compact('clarify'));
    }


    public function UpdateClarifies(Request $request)
    {
        $clarify_id = $request->id;
        $clarify = Clarify::find($clarify_id);

        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img =$manager->read($image);
            $img->resize(306,618)->save(public_path('upload/clarify/'.$name_gen));
            $save_url = 'upload/clarify/'.$name_gen;

            if(file_exists(public_path($clarify->image))){
                @unlink(public_path($clarify->image));
            }
            
            Clarify::find($clarify_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $save_url,

            ]);
            $notification = array(
                'message' =>  'Clarifies Updated with image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }else{
            Clarify::find($clarify_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                

            ]);
            $notification = array(
                'message' =>  'Clarifies Updated without image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }

        
    }

    
}
