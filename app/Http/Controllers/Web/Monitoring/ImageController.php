<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageIntervention;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => $request->file('image'),
            'label' => $request->label,
            'description' => $request->description,
            'monitoring_id' => $request->monitoringId,
        ];
        $file = $request->file('image');
        $filename = 'data-'.Str::slug($request->label).'-'.time().'-'.uniqid().'.'.$file->extension();
        $image = ImageIntervention::make($file->path());
        $this->checkDirectory('/monitoring/data');
        $image->resize(780, 780, function($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('/monitoring/data/').$filename);
        $data['name'] = $filename;
        Image::query()->create($data);
        return redirect()->back()->with('message', 'Gambar berhasil disimpan')->with('status', 'success');

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
            'name' => $request->file('image'),
            'label' => $request->label,
            'description' => $request->description,
            'monitoring_id' => $request->monitoringId,
        ];
        $image = Image::query()->find($id);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'data-'.Str::slug($request->label).'-'.time().'-'.uniqid().'.'.$file->extension();
            $image = ImageIntervention::make($file->path());
            $this->checkDirectory('/monitoring/data');
            if(File::exists(public_path('/monitoring/data/').$image->name)) {
                File::delete(public_path('/monitoring/data/').$image->name);
            }
            $image->resize(780, 780, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/data/').$filename);
            $data['name'] = $filename;
        } else {
            unset($data['name']);
        }
        Image::query()->where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Gambar berhasil dirubah')->with('status', 'success');
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
        if(File::exists(public_path('/monitoring/data/').$image->name)) {
            File::delete(public_path('/monitoring/data/').$image->name);
        }
        $image->delete();
        return redirect()->back()->with('message', 'Gambar berhasil dihapus')->with('status', 'success');
    }
}
