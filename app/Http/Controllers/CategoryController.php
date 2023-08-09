<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;
use App\Models\User;
use App\Models\Image;
use App\Models\userDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
class CategoryController extends Controller
{

    
    public function userList(Request $request): JsonResponse
    {
        try {
            $User = User::where("user_type",$request->user_type)->get();
            return $this->sendResponse($User, 'User List get successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('User list not geting !! .');

        }
    }

    public function imageUpload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $image_type = $request->image_type;
            $model_name = $request->model_name;
            $image_name = $request->file('image')->getClientOriginalName();
            $path = "storage/app/".$request->file('image')->store('public/'.$model_name);
            $image = new Image;
            $image->image_name = $image_name;
            $image->url = $path;
            $image->model_name = $model_name;
            $image->image_type = $image_type;     
            $image->save();
            return $this->sendResponse($image, 'Image upload seccess');

        } catch (\Throwable $th) {
            return $this->sendError('Server Error.');

        }

    }

    public function addCategory(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
                'price' => 'required',
                'price_type' => 'required',
                'image_url' => 'required',
                'image_id' => 'required',
            ]);
         
            if($validator->fails()){
                return $this->sendError('Validation Error.');       
            }
         
            $input = $request->all();
            $input["user_id"] = Auth::user()->id;
            $Category = Category::create($input);
       
            return $this->sendResponse($Category, 'Category create successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Category not created , please try once !! .');

        }

    }

    public function categoryList(Request $request): JsonResponse
    {
        try {
            $Categories = Category::get();
            return $this->sendResponse($Categories, 'Category List get successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Category list not geting !! .');

        }
    }

    public function categoryEdit(Request $request): JsonResponse
    {
        try {
            $Categories = Category::where('id',$request->id)->update($request->all());
            return $this->sendResponse($Categories, 'Category update successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Category update not !! .');

        }
    }

    public function categoryDelete(Request $request): JsonResponse
    {
        try {
            $Categories = Category::where("id",$request->id)->delete();
            return $this->sendResponse($Categories, 'Category delete successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Category not delete  !! .');

        }
    }



    ///////////////Banner ////////////////


    public function bannerAdd(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'banner_name' => 'required',
                'image_url' => 'required',
                'image_id' => 'required',
            ]);
         
            if($validator->fails()){
                return $this->sendError('Validation Error.');       
            }
         
            $input = $request->all();
            $input["status"]=true;
            $Banner = Banner::create($input);
            return $this->sendResponse($Banner->all(), 'Banner create successfully.');
       
            return $this->sendResponse($Banner, 'Banner create successfully.');
        } catch (\Throwable $th) {
            return $this->sendError("Server Error");

        }

    }

    public function bannerList(Request $request)
    {
        try {
            $Banner = Banner::get();
            return $this->sendResponse($Banner, 'Banner List get successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Banner list not geting !! .');

        }
    }

    public function bannerEdit(Request $request)
    {
        try {
            $Banner = Banner::where('id',$request->id)->update($request->all());
            if ($Banner) {
                return $this->sendResponse($Banner, 'Banner update successfully .');

            } else {
                return $this->sendError('Banner not update !! .');

            }
            
        } catch (\Throwable $th) {
            return $this->sendError('Banner update not !! .');

        }
    }

    public function bannerDelete(Request $request)
    {
        try {
            $Banner = Banner::where("id",$request->id)->delete();
            return $this->sendResponse($Banner, 'Banner delete successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Banner not delete  !! .');

        }
    }

    public function addProfileDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "id" => 'required',
                "name" => 'required',
                "email" => 'required',
                "phone" => 'required',
                "address_one" => 'required',
                "pin" => 'required',
                "save_for" => 'required',
                "latitude" => 'required',
                "longitude" => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.');       
            }
            $user = User::where('id',$request->id)->update($request->all());
            if ($user) {
                return $this->sendResponse($user, 'User update successfully.');
            } else {
                return $this->sendError('User not Update  , please try once!! .');
            }
               } catch (\Throwable $th) {
            return $this->sendError('User not Update  !! .');
        }
    }

    public function addDeviceInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "platform" => "required",
                "operating_system" => "required",
                "os_version" => "required",
                "manufacturer" => "required",
                "is_virtual" => "required",
                "web_view_version" => "required",
                "model" => "required",
                "device_name" => "required",
                "location" => "required",
                "fcm_token" => "required",
                "ip_Address" => "required"
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.');       
            }
            $userInfo = $request->all();
            $userInfo["user_id"] = Auth::user()->id;
            $user = userDetail::create($userInfo);
            if ($user) {
                return $this->sendResponse($user, 'Device create successfully.');
            } else {
                return $this->sendError('Device not creat  , please try once!! .');
            }
               } catch (\Throwable $th) {
            return $this->sendError($th);
        }
    }

    public function getProfileDetails(Request $request)
    {
        try {
            $user = User::where("id",Auth::user()->id)->first();
            if ($user) {
                return $this->sendResponse($user, 'user details get successfully .');
            } else {
                return $this->sendError('user details not found');
            }
        } catch (\Throwable $th) {
            return $this->sendError('user details not found');

        }
    }

    public function addOrder(Request $request)
    {
        try {
            if ($request->hasFile('direction_mp3')) {
                $location = time().'.'.$request->direction_mp3->extension();  
     
                $path=$request->direction_mp3->move(public_path('audio'), $location);
            }
            $path2=url('/').'/'.$location;
            $order_id=Str::random(10);
            $create=Order::create([
                'voice'=>$path2,
                'name'=>$request->name,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'user_id'=>Auth::user()->id,
                'category_id'=>$request->category_id,
                'order_date'=>$request->order_date,
                'category_name'=>$request->category_name,
                'pickup_request_date'=>$request->pickup_request_date,
                'img_url'=>$request->img_url,
                'order_status'=>1,
                'order_unick_id'=>$order_id,
                'status'=>1,
            ]);
            return $this->sendResponse($create, 'Order create successfully .');
        } catch (\Throwable $th) {
            return $this->sendError('Server Error.');

        }

    }
    
}
