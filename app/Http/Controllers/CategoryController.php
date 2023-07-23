<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{
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
                return $this->sendError('Validation Error.', $validator->errors());       
            }
         
            $input = $request->all();
            $input["user_id"] = Auth::user()->id;
            $Category = Category::create($input);
       
            return $this->sendResponse($Category, 'Category create successfully.');
        } catch (\Throwable $th) {
            return $this->sendError($th, 'Category not created , please try once !! .');

        }

    }
   public function imageUpload(Request $request): JsonResponse
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
            return $this->sendError($th, 'Server Error.');

        }
    
    }
    
}
