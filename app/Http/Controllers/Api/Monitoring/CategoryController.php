<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\CreateData;
use App\Jobs\Monitoring\Category\EditData;
use App\Models\Monitoring\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('object', 'categoryObject', 'categoryObject.monitoring')->get();
        return $this->jsonResponse($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'name' => 'required',
            'icon' => 'mimes:jpg,png,jpeg|max:1024'
        ];
        $data = [
            'name' => $request->name,
            'icon' => $request->file('icon'),
            'description' => $request->description,
        ];
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = 'category-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            $icon->move(public_path('/monitoring/icon/'), $iconName);
            $data['icon'] = $iconName;
        } else {
            unset($data['icon']);
            unset($rules['icon']);
        }
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $category = Category::query()->create($data);
        return $this->jsonResponse($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with('object', 'categoryObject', 'categoryObject.monitoring')->find($id);
        return $this->jsonResponse($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'icon' => 'mimes:jpg,png,jpeg|max:1024'
        ];
        $data = [
            'name' => $request->name,
            'icon' => $request->file('icon'),
            'description' => $request->description,
        ];
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $category = Category::query()->find($id);
            $iconName = 'category-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            if(File::exists(public_path('/monitoring/icon/').$category->icon)) {
                File::delete(public_path('/monitoring/icon/').$category->icon);
            }
            $icon->move(public_path('/monitoring/icon/'), $iconName);
            $data['icon'] = $iconName;
        } else {
            unset($data['icon']);
            unset($rules['icon']);
        }
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Category::query()->where('id', $id)->update($data);
        $category = Category::query()->find($id);
        return $this->jsonResponse($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(File::exists(public_path('/monitoring/icon/').$category->icon)) {
            File::delete(public_path('/monitoring/icon/').$category->icon);
        }
        $category->delete();
        return $this->jsonResponse($category);
    }

    public function addObject(Request $request, $id)
    {
        $rules = [
            'objectId' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Category::find($id)->object()->attach($request->objectId);
        $category = Category::with('object', 'categoryObject', 'categoryObject.monitoring')->find($id);
        return $this->jsonResponse($category);
    }

    public function removeObject(Request $request, $id)
    {
        $rules = [
            'objectId' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Category::find($id)->object()->detach($request->objectId);
        $category = Category::with('object', 'categoryObject', 'categoryObject.monitoring')->find($id);
        return $this->jsonResponse($category);
    }
}
