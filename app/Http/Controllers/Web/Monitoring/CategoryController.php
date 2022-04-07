<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\CreateData;
use App\Jobs\Monitoring\Category\EditData;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
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
        $categories = Category::query()->get();
        return Inertia::render('Monitoring/Category/Index', ['categories' => $categories]);
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
        ];
        if($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'icon-'.Str::slug($request->name).'-'.uniqid().'.'.$file->extension();
            $image = Image::make($file->path());
            $image->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/icon/'.$filename));
            $data['icon'] = $filename;
        } else {
            unset($data['icon']);
        }
        CreateData::dispatch($data);
        Category::query()->create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        ];
        $category = Category::query()->find($id);
        if($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'icon-'.Str::slug($request->name).'-'.uniqid().'.'.$file->extension();
            $image = Image::make($file->path());
            $this->checkDirectory('/monitoring/icon');
            if(File::exists(public_path('/monitoring/icon/').$category->icon)) {
                File::delete(public_path('/monitoring/icon/').$category->icon);
            }
            $image->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/icon/'.$filename));
            $data['icon'] = $filename;
        } else {
            unset($data['icon']);
        }
        EditData::dispatch($data);
        $category->update($data);
        return redirect()->back();
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
        return redirect()->back();
    }
}
