<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\EditData;
use App\Jobs\Monitoring\Option\CreateData;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputOption;
use App\Models\Monitoring\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = InputOption::query()->with('input')->get();
        return $this->jsonResponse($options);
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
            'monitoring_input_id' => 'required',
            'value' => 'required',
        ];
        $data = [
            'monitoring_input_id' => $request->input_id,
            'value' => $request->value,
            'is_checked' => $request->is_checked,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $option = InputOption::query()->create($data);
        return $this->jsonResponse($option);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = InputOption::query()->with('input')->find($id);
        return $this->jsonResponse($option);
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
            'monitoring_input_id' => 'required',
            'value' => 'required',
        ];
        $data = [
            'monitoring_input_id' => $request->input_id,
            'value' => $request->value,
        ];
        $checkModeInput = Input::where('id', $request->input_id)->first();
        $checkOption = InputOption::query()->find($id);
        // return $this->jsonResponse([$checkModeInput, $checkOption, $request->is_checked]);
        $optionValueCheck = OptionValue::where('monitoring_input_id', $request->input_id)
                        ->where('monitoring_id', $request->monitoring_id)
                        ->where('monitoring_input_option_id', $id)
                        ->first();
        $optionValueCheckSingle = OptionValue::where('monitoring_input_id', $request->input_id)
                        ->where('monitoring_id', $request->monitoring_id)
                        ->first();
        InputOption::query()->where('id', $id)->update(array_merge($data, [
            'is_checked' => $request->is_checked,
        ]));
        // return $this->jsonResponse($optionValueCheckSingle);
        if($checkModeInput->type == 'checkbox') {
            if($request->is_checked == 1 && $optionValueCheck == null) {
                OptionValue::query()->create(array_merge($data, [
                    'monitoring_id' => $request->monitoring_id,
                    'monitoring_input_option_id' => $id,
                ]));
            }
            if($request->is_checked == 0 && $optionValueCheck != null) {
                OptionValue::query()->where('monitoring_id', $request->monitoring_id)
                    ->where('monitoring_input_option_id', $id)
                    ->where('monitoring_input_id', $request->input_id)
                    ->delete();
            }
        } else {
            // reset values
            // return $this->jsonResponse($request->is_checked);
            if($request->value != null && $request->value != '') {
                if($optionValueCheckSingle != null) {
                    OptionValue::query()->where('id', $optionValueCheckSingle->id)->update(array_merge($data, [
                        'monitoring_id' => $request->monitoring_id,
                        'monitoring_input_option_id' => $id,
                    ]));
                } else {
                    if($request->is_checked == 1) {
                        OptionValue::query()->create(array_merge($data, [
                            'monitoring_id' => $request->monitoring_id,
                            'monitoring_input_option_id' => $id,
                        ]));
                    }
                }
            } else {
                OptionValue::query()->where('monitoring_id', $request->monitoring_id)
                    ->where('monitoring_input_id', $request->input_id)
                    ->delete();
            }
        }
        // if($request->is_checked == 0 && $optionValueCheck != null) {
        //     OptionValue::query()->where()
        // }
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $option = InputOption::query()->find($id);
        return $this->jsonResponse($option);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = InputOption::query()->find($id);
        OptionValue::query()->where('monitoring_input_option_id', $id)->delete();
        $option->delete();
        return $this->jsonResponse($option);
    }
}
