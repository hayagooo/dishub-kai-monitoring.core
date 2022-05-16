<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Input\CreateData;
use App\Jobs\Monitoring\Input\EditData;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class InputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = Input::query()->with('monitoring', 'option', 'category', 'object')
        ->when($request->get('category_id') != null, function($query) use($request) {
            $query->where('monitoring_category_id', $request->get('category_id'));
        })
        ->when($request->get('object_id') != null, function($query) use($request) {
            $query->where('monitoring_object_id', $request->get('object_id'));
        })
        ->when($request->get('monitoring_id') != null, function($query) use($request) {
            $query->where('monitoring_id', $request->get('monitoring_id'));
        })->get();
        return $this->jsonResponse($inputs);
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
            'monitoring_category_id' => 'required',
            'monitoring_object_id' => 'nullable',
            'monitoring_id' => 'nullable',
            'label' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required',
            'is_required' => 'required',
            'link' => 'nullable|url',
            'placeholder' => 'nullable',
            'description' => 'nullable',
        ];
        $data = [
            'monitoring_category_id' => $request->category_id,
            'monitoring_object_id' => $request->object_id,
            'monitoring_id' => $request->monitoring_id,
            'image' => $request->file('image'),
            'is_required' => $request->is_required,
            'label' => $request->label,
            'link' => $request->link,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'description' => $request->description,
        ];
        Validator::make($data, $rules)->validate();
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'input-'.Str::slug($request->label).'-'.time().'-'.uniqid().'.'.$file->extension();
            $image = Image::make($file->path());
            $dimension = 480;
            if($request->type == 'image') $dimension = 720;
            $image->resize($dimension, $dimension, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/input/'.$fileName));
            $data['image'] = $fileName;
        }
        $input = Input::query()->create($data);
        $decodeOptions = json_decode($request->options);
        if(count($decodeOptions) > 0) {
            foreach($decodeOptions as $item) {
                $option = new InputOption();
                $option->monitoring_input_id = $input->id;
                $option->value = $item->value;
                $option->save();
            }
        }
        $data = Input::query()->with('option')->find($input->id);
        return $this->jsonResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $input = Input::query()->with('monitoring', 'option')->find($id);
        return $this->jsonResponse($input);
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
            'monitoring_category_id' => 'required',
            'monitoring_object_id' => 'nullable',
            'monitoring_id' => 'nullable',
            'label' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required',
            'is_required' => 'required',
            'link' => 'nullable|url',
            'placeholder' => 'nullable',
            'description' => 'nullable',
        ];
        $data = [
            'monitoring_category_id' => $request->category_id,
            'monitoring_object_id' => $request->object_id,
            'monitoring_id' => $request->monitoring_id,
            'image' => $request->file('image'),
            'is_required' => $request->is_required,
            'link' => $request->link,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'description' => $request->description,
        ];
        Validator::make($data, $rules)->validate();
        $input = Input::query()->find($id);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'input-'.Str::slug($request->label).'-'.time().'-'.uniqid().'.'.$file->extension();
            $image = Image::make($file->path());
            $dimension = 480;
            if($request->type == 'image') $dimension = 720;
            $this->checkDirectory('/monitoring/input');
            if(File::exists(public_path('/monitoring/icon/').$input->image)) {
                File::delete(public_path('/monitoring/icon/').$input->image);
            }
            $image->resize($dimension, $dimension, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/monitoring/input/'.$fileName));
            $data['image'] = $fileName;
        } else {
            unset($data['image']);
        }
        Input::query()->where('id', $id)->update($data);
        $decodeOptions = json_decode($request->options);
        if(count($decodeOptions) > 0) {
            $itemIds = [];
            foreach($decodeOptions as $item) {
                $itemIds[] = $item->id;
                if($item->id == null) {
                    $option = new InputOption();
                    $option->monitoring_input_id = $id;
                    $option->value = $item->value;
                    $option->save();
                } else {
                    $data = [
                        'value' => $item->value,
                        'monitoring_input_id' => $id,
                    ];
                    InputOption::query()->where('id', $item->id)->update($data);
                }
            }
        }
        $data = Input::query()->with('option')->find($id);
        return $this->jsonResponse($data);
    }

    public function deleteImage($id)
    {
        $input = Input::query()->find($id);
        if(File::exists(public_path('/monitoring/icon/').$input->image)) {
            File::delete(public_path('/monitoring/icon/').$input->image);
        }
        $input->image = null;
        $input->save();
        return $this->jsonResponse($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = Input::query()->with('option')->find($id);
        if(File::exists(public_path('/monitoring/icon/').$input->image)) {
            File::delete(public_path('/monitoring/icon/').$input->image);
        }
        $input->option()->delete();
        $input->delete();
        return $this->jsonResponse($input);
    }
}
