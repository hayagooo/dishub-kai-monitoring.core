<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Input\CreateData;
use App\Jobs\Monitoring\Input\EditData;
use App\Models\Monitoring\Input;
use Illuminate\Http\Request;

class InputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inputs = Input::query()->with('monitoring', 'option')->get();
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
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'text' => $request->text,
            'number' => $request->number,
        ];
        CreateData::dispatch($data);
        $input = Input::query()->create($data);
        return $this->jsonResponse($input);
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
        $data = [
            'monitoring_id' => $request->monitoring_id,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'text' => $request->text,
            'number' => $request->number,
        ];
        EditData::dispatch($data);
        $input = Input::query()->where('id', $id)->update($data);
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
