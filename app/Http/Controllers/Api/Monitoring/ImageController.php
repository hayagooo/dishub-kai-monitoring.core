<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Image\CreateData;
use App\Jobs\Monitoring\Image\EditData;
use App\Models\Monitoring\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::query()->with('monitoring')->get();
        return $this->jsonResponse($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'monitoring_id' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'label' => 'required',
        ];
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'name' => $request->file('image'),
            'label' => $request->label,
            'description' => $request->description,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $file = $request->file('image');
        $fileName = 'monitoring-'.Str::slug($request->label).'-'.uniqid().'.'.$file->extension();
        $this->checkDirectory('/monitoring/image/');
        $file->move(public_path('/monitoring/image/'), $fileName);
        $data['name'] = $fileName;
        $image = Image::query()->create($data);
        return $this->jsonResponse($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::query()->with('monitoring')->find($id);
        return $this->jsonResponse($image);
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
            'monitoring_id' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'label' => 'required',
        ];
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'name' => $request->file('image'),
            'label' => $request->label,
            'description' => $request->description,
        ];
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'monitoring-'.Str::slug($request->label).'-'.uniqid().'.'.$file->extension();
            $this->checkDirectory('/monitoring/image/');
            $image = Image::query()->find($id);
            if(File::exists(public_path('/monitoring/image/').$image->name)) {
                File::delete(public_path('/monitoring/image/').$image->name);
            }
            $file->move(public_path('/monitoring/image/'), $fileName);
            $data['name'] = $fileName;
        } else {
            unset($rules['image']);
            unset($data['name']);
        }
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Image::query()->where('id', $id)->update($data);
        $image = Image::query()->find($id);
        return $this->jsonResponse($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::query()->find($id);
        if(File::exists(public_path('/monitoring/image/').$image->name)) {
            File::delete(public_path('/monitoring/image/').$image->name);
        }
        $image->delete();
        return $this->jsonResponse($image);
    }
}
