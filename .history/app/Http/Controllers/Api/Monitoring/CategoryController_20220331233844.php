<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\CreateData;
use App\Jobs\Monitoring\Category\EditData;
use App\Models\Monitoring\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $data = [
            'name' => $request->name,
            'icon' => $request->file('icon'),
            'description' => $request->description,
        ];
        CreateData::dispatch($data);
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = 'category-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            $icon->move(public_path('/monitoring/icon/'), $iconName);
            $data['icon'] = $iconName;
        }
        $category = Category::query()->create($data);
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
        $data = [
            'name' => $request->name,
            'icon' => $request->file('icon'),
            'description' => $request->description,
        ];
        EditData::dispatch($data);
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = 'category-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            $icon->move(public_path('/monitoring/icon/'), $iconName);
            $data['icon'] = $iconName;
        }
        $category = Category::query()->where('id', $id)->update($data);
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
        $category = Category::find($id);
        $category->object()->attach($request->objectId);
        return $this->jsonResponse($category);
    }

    public function removeObject(Request $request, $id)
    {
        $category = Category::find($id);
        $category->object()->detach($request->objectId);
        return $this->jsonResponse($category);
    }
}
