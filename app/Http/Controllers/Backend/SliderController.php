<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class SliderController extends Controller
{
    public function GetSlider()
    {
        $slider = Slider::find(1);
        return view('admin.backend.slider.get_slider',compact('slider'));
    }
     public function UpdateSlider(Request $request)
    {
        $slider_id = $request->id;
        $slider = Slider::find($slider_id);

        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img =$manager->read($image);
            $img->resize(306,618)->save(public_path('upload/slider/'.$name_gen));
            $save_url = 'upload/slider/'.$name_gen;

            if(file_exists(public_path($slider->image))){
                @unlink(public_path($slider->image));
            }
            
            Slider::find($slider_id)->update([
                'title' => $request->title,
                'descriptions' => $request->descriptions,
                'link' => $request->link,
                'image' => $save_url,

            ]);
            $notification = array(
                'message' =>  'Slider Updated with image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }else{
            Slider::find($slider_id)->update([
                'title' => $request->title,
                'descriptions' => $request->descriptions,
                'link' => $request->link,
                

            ]);
            $notification = array(
                'message' =>  'Slider Updated without image successfully',
                'alert_type' => 'success',
            );
            return redirect()->back()->with($notification);
        }

        
    }
}
