<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Clarify;
use App\Models\Connect;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Usability;
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


    // Clarifies Section
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

    public function GetUsability()
    {
        $usability = Usability::find(1);
        return view('admin.backend.usability.get_usability', compact('usability'));
    }


     public function UpdateUsability(Request $request)
    {
        $usability_id = $request->id;
        $usability = Usability::find($usability_id);

        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img =$manager->read($image);
            $img->resize(560,400)->save(public_path('upload/usability/'.$name_gen));
            $save_url = 'upload/usability/'.$name_gen;

            if(file_exists(public_path($usability->image))){
                @unlink(public_path($usability->image));
            }
            
            Usability::find($usability_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'youtube' => $request->youtube,
                'link' => $request->link,
                'image' => $save_url,

            ]);
            $notification = array(
                'message' =>  'Usability Updated with image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }else{
            Usability::find($usability_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'youtube' => $request->youtube,
                'link' => $request->link,

            ]);
            $notification = array(
                'message' =>  'Usability Updated without image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
        
    }

    //Connect Section

    public function AllConnect()
    {
        $connect = Connect::latest()->get();
        return view('admin.backend.connect.all_connect',compact('connect'));
    }

    public function AddConnect()
    {
        return view('admin.backend.connect.add_connect');
    }

    public function StoreConnect(Request $request)
    {
            Connect::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' =>  'Connect Inserted successfully',
                'alert_type' => 'success',
            );
            return redirect()->route('all.connect')->with($notification);
    }

    public function UpdateConnect(Request $request, $id)
    {
        $connect = Connect::findOrFail($id);

        $connect->update($request->only(['title','description']));
        return response()->json(['success'=>true, 'message'=>'Updated Successfully']);
    }

    //Faq Section
    public function AllFaq()
    {
        $faq = Faq::latest()->get();
        return view('admin.backend.faq.all_faq',compact('faq'));
    }

    public function AddFaq()
    {
        return view('admin.backend.faq.add_faq');
    }

    public function StoreFaq(Request $request)
    {
            Faq::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' =>  'Faq Inserted successfully',
                'alert_type' => 'success',
            );
            return redirect()->route('all.faq')->with($notification);
    }

    public function EditFaq($id)
    {
        $faq = Faq::find($id);
        return view('admin.backend.faq.edit_faq',compact('faq'));
    }

    public function UpdateFaq(Request $request)
    {
            $faq_id = $request->id;

            Faq::find($faq_id)->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $notification = array(
                'message' =>  'Faq Updated successfully',
                'alert_type' => 'success',
            );
            return redirect()->route('all.faq')->with($notification);
    }

    public function DeleteFaq($id)
    {

        Faq::find($id)->delete();

        $notification = array(
                'message' =>  'Faq Deleted successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
    }


    public function UpdateApps(Request $request, $id)
    {
        $app = App::findOrFail($id);

        $app->update($request->only(['title','description']));
        return response()->json(['success'=>true, 'message'=>'Updated Successfully']);
    }

    public function UpdateAppsImage(Request $request, $id)
    {
        $apps = App::findOrFail($id);


        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img =$manager->read($image);
            $img->resize(306,481)->save(public_path('upload/apps/'.$name_gen));
            $save_url = 'upload/apps/'.$name_gen;

            if(file_exists(public_path($apps->image))){
                @unlink(public_path($apps->image));
            }

            $apps->update([
                'image' => $save_url,
            ]);
            return response()->json([
                'success' => true,
                'image_url' => asset($save_url),
                'message' => 'Image Updated Successfully',

            ]);
            
        }

        return response()->json(['success' => false, 'message' => 'Image Upload Failed'], 400);

        
    }
}
