<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Input\CreateData;
use App\Jobs\Monitoring\Input\EditData;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputOption;
use Illuminate\Http\Request;
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
            'label' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'type' => 'required',
        ];
        $data = [
            'monitoring_category_id' => $request->category_id,
            'monitoring_object_id' => $request->object_id,
            'monitoring_id' => $request->monitoring_id,
            // 'image' => $request->file('image'),
            'is_required' => $request->is_required,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'description' => $request->description,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
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
            'monitoring_id' => 'required',
            'label' => 'required',
            'type' => 'required',
        ];
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'text' => $request->text,
            'number' => $request->number,
            'description' => $request->description,
            'is_required' => $request->is_required,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Input::query()->where('id', $id)->update($data);
        $input = Input::query()->find($id);
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
        $input = Input::query()->find($id);
        $input->delete();
        return $this->jsonResponse($input);
    }
}
