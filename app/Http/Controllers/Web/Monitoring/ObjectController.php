<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Object\CreateData;
use App\Jobs\Monitoring\Object\EditData;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Image;
use App\Models\Monitoring\ObjectData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objects = ObjectData::query()->with('category', 'categoryObject', 'categoryObject.monitoring')->get();
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Object/Index', [
            'objects' => $objects,
            'category' => $category,
        ]);
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
            $this->checkDirectory('/monitoring/icon');
            $image->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/icon/'.$filename));
            $data['icon'] = $filename;
        } else {
            unset($data['icon']);
        }
        CreateData::dispatch($data);
        ObjectData::query()->create($data);
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
        $object = ObjectData::query()->find($id);
        if($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'icon-'.Str::slug($request->name).'-'.uniqid().'.'.$file->extension();
            $image = Image::make($file->path());
            $this->checkDirectory('/monitoring/icon');
            if(File::exists(public_path('/monitoring/icon/').$object->icon)) {
                File::delete(public_path('/monitoring/icon/').$object->icon);
            }
            $image->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/icon/'.$filename));
            $data['icon'] = $filename;
        } else {
            unset($data['icon']);
        }
        EditData::dispatch($data);
        $object->update($data);
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
        $object = ObjectData::find($id);
        if(File::exists(public_path('/monitoring/icon/').$object->icon)) {
            File::delete(public_path('/monitoring/icon/').$object->icon);
        }
        $object->delete();
        return redirect()->back();
    }
}
