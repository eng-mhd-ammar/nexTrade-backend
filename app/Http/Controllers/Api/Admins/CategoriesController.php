<?php

namespace App\Http\Controllers\Api\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    
    use ApiTrait;

    public function create(Request $request)
    {
        try {
            $rules = [
                'image' => 'required|mimes:svg',
                'name_en' => 'required',
                'name_ar' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $path = $request->file('image')->store('images/categories', 'public');
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => $path,
            ];
            Category::create($data);
            return $this->returnSuccessMessage('Category Created');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function get()
    {
        try {
            $data = Category::all();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $rules = ['category_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $category = Category::find($request->category_id);
            if (!$category) return $this->returnError('Category Not Found');
            Storage::disk('public')->delete($category->image);
            $category->delete();
            return $this->returnSuccessMessage('Category Deleted');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $rules = [
                'category_id' => 'required',
                'name_en' => 'required',
                'name_ar' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $category = Category::find($request->category_id);
            if (!$category) return $this->returnError('Category Not Found');
            if ($request->image) {
                Storage::disk('public')->delete($category->image);
                $path = $request->file('image')->store('images/categories', 'public');
                $category->image = $path;
            }
            if ($category->name_en != $request->name_en) $category->name_en = $request->name_en;
            if ($category->name_ar != $request->name_ar) $category->name_ar = $request->name_ar;
            $category->save();
            return $this->returnSuccessMessage('Category Updated');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
