<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\EditData;
use App\Jobs\Monitoring\Option\CreateData;
use App\Models\Monitoring\InputOption;
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
            'is_checked' => $request->is_checked,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        InputOption::query()->where('id', $id)->update($data);
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
        $option->delete();
        return $this->jsonResponse($option);
    }
}
