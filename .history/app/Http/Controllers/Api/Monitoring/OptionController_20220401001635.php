<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Category\EditData;
use App\Jobs\Monitoring\Option\CreateData;
use App\Models\Monitoring\InputOption;
use Illuminate\Http\Request;

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
        $data = [
            'monitoring_input_id' => $request->input_id,
            'value' => $request->value,
            'is_checked' => $request->value,
        ];
        CreateData::dispatch($data);
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
        $data = [
            'monitoring_input_id' => $request->input_id,
            'value' => $request->value,
            'is_checked' => $request->value,
        ];
        EditData::dispatch($data);
        $option = InputOption::query()->where('id', $id)->update($data);
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
