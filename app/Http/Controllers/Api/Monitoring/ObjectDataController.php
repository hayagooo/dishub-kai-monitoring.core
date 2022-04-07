<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Object\CreateData;
use App\Models\Monitoring\ObjectData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ObjectDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ObjectData::query()->with('category', 'categoryObject', 'categoryObject.monitoring');
        $objects = $query->when($request->category_id != null, function($queryObject, $request) {
            $queryObject->whereHas('category', function($object) use($request) {
                $object->where('monitoring_category_id', $request->get('category_id', 1));
            });
        })->get();
        return $this->jsonResponse($objects);
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
        return $this->jsonResponse($data);
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = 'object-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
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
        $object = ObjectData::query()->create($data);
        return $this->jsonResponse($object);
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
            $object = ObjectData::query()->find($id);
            $iconName = 'object-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            if(File::exists(public_path('/monitoring/icon/').$object->icon)) {
                File::delete(public_path('/monitoring/icon/').$object->icon);
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
        ObjectData::query()->where('id', $id)->update($data);
        $object = ObjectData::query()->find($id);
        return $this->jsonResponse($object);
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
        return $this->jsonResponse($object);
    }
}
