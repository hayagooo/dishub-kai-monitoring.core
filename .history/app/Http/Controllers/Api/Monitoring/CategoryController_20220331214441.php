<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\CreateData;
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
        $categories = Category::all();
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
            $this->checkDirectory();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
