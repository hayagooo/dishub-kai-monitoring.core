<?php

namespace App\Http\Controllers\Api\Information;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $informations = Information::query()->when($request->get('title') != null, function($query) use($request) {
            $query->where('title', 'like', '%'.$request->get('title').'%');
        })
        ->orderBy('created_at' ,$request->get('sort', 'DESC'))
        ->paginate(10);
        return $this->jsonResponse($informations);
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
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'image' => $request->file('image'),
            'document' => $request->file('document'),
        ];
        $rules = [
            'title' => 'required',
            'link' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'document' => 'nullable|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx'
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image-'.Str::slug($request->title).'-'.time().'-'.uniqid().'.'.$image->extension();
            $img = Image::make($image->path());
            $this->checkDirectory('/information/image/');
            $img->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/information/image/').$imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        if($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = Str::slug($request->title).'-'.time().'-'.uniqid().'.'.$file->extension();
            $this->checkDirectory('/information/data/');
            $file->move(public_path('/information/data/'), $fileName);
            $data['document'] = $fileName;
        } else {
            unset($data['document']);
        }
        $information = Information::query()->create($data);
        return $this->jsonResponse($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $name = str_replace('-', ' ', $request->get('title'));
        $information = Information::query()->where('id', $id)->orWhere('title', 'LIKE', '%'.$name.'%')->first();
        return $this->jsonResponse($information);
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
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'image' => $request->file('image'),
            'document' => $request->file('document'),
        ];
        $rules = [
            'title' => 'required',
            'link' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'document' => 'nullable|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx'
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $information = Information::query()->find($id);
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'image-'.Str::slug($request->title).'-'.time().'-'.uniqid().'.'.$image->extension();
            $img = Image::make($image->path());
            $this->checkDirectory('/information/image/');
            if($information->image != null) {
                if(File::exists(public_path('/information/image/'))) unlink(public_path('/information/image/').$information->image);
            }
            $img->resize(750, 750, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/information/image/').$imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        if($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = Str::slug($request->title).'-'.time().'-'.uniqid().'.'.$file->extension();
            $this->checkDirectory('/information/data/');
            if($information->document != null) {
                if(File::exists(public_path('/information/data/'))) unlink(public_path('/information/data/').$information->document);
            }
            $file->move(public_path('/information/data/'), $fileName);
            $data['document'] = $fileName;
        } else {
            unset($data['document']);
        }
        Information::query()->where('id', $id)->update($data);
        $information = Information::query()->find($id);
        return $this->jsonResponse($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $information = Information::query()->find($id);
        if($information->image != null) {
            if(File::exists(public_path('/information/image/'))) unlink(public_path('/information/image/').$information->image);
        }
        if($information->document != null) {
            if(File::exists(public_path('/information/data/'))) unlink(public_path('/information/data/').$information->document);
        }
        $information->delete();
        return $this->jsonResponse($information);
    }

    public function deleteImage($id)
    {
        $information = Information::query()->find($id);
        if($information->image != null) {
            if(File::exists(public_path('/information/image/'))) unlink(public_path('/information/image/').$information->image);
        }
        $information->image = null;
        $information->save();
        return $this->jsonResponse($information);
    }
}
