<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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
            ]);
         
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
         
            $input = $request->all();
            // $input["user_id"] = Auth::user()->id;
            $Category = Category::create($input);
       
            return $this->sendResponse($Category, 'Category create successfully.');
        } catch (\Throwable $th) {
            return $this->sendError($th, 'Category not created , please try once !! .');

        }

    }
}
