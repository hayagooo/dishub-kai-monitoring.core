<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Image\CreateData;
use App\Jobs\Monitoring\Image\EditData;
use App\Models\Monitoring\Image;
use Illuminate\Http\Request;
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
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'name' => $request->name,
            'label' => $request->label,
            'description' => $request->description,
        ];
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'monitoring-'.Str::slug($request->label).'-'.uniqid().'.'.$file->extension();
        }
        CreateData::dispatch($data);
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
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'name' => $request->name,
            'label' => $request->label,
            'description' => $request->description,
        ];
        EditData::dispatch($data);
        $image = Image::query()->where('id', $id)->update($data);
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
        $image->delete();
        return
    }
}
