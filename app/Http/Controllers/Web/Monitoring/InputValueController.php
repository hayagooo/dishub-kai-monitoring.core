<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputOption;
use App\Models\Monitoring\InputValue;
use App\Models\Monitoring\OptionValue;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InputValueController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'monitoring_input_id' => $request->input_id,
            'type' => $request->type,
            'monitoring_id' => $request->monitoring_id,
            'string_value' => $request->string_value,
            'text_value' => $request->text_value,
            'date_value' => $request->date_value,
            'time_value' => $request->time_value,
            'number_value' => $request->number_value,
            'file_value' => $request->file('file'),
            'type_file' => $request->type_file,
        ];
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'input-value-'.time().'-'.uniqid().'.'.$file->extension();
            $this->checkDirectory('/monitoring/value/');
            if($request->file_type == 'image') {
                $image = Image::make($file->path());
                $image->resize(720, 720, function($constraint) {
                    $constraint->aspectrRatio();
                })->save(public_path('/monitoring/value/').$filename);
            } else {
                $file->move(public_path('/monitoring/value/'), $filename);
            }
            $data['file_value'] = $filename;
        }
        // $checkValue = InputValue::query()->where('monitoring_id', $request->monitoring_id)
        //     ->with('monitoring_input_id', $request->input_id)->first();
        // if($checkValue != null) {
        //     $checkValue->delete();
        // }
        InputValue::query()->create($data);
        return redirect()->back()->with('message', 'Input Value Berhasil Diupdate')->with('status', 'success');
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
            'monitoring_input_id' => $request->input_id,
            'type' => $request->type,
            'monitoring_id' => $request->monitoring_id,
            'string_value' => $request->string_value,
            'text_value' => $request->text_value,
            'date_value' => $request->date_value,
            'time_value' => $request->time_value,
            'number_value' => $request->number_value,
            'file_value' => $request->file('file'),
            'type_file' => $request->type_file,
        ];
        $value = InputValue::query()->find($id);
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'input-value-'.time().'-'.uniqid().'.'.$file->extension();
            $this->checkDirectory('/monitoring/value/');
            if(File::isDirectory(public_path('/monitoring/value/').$value->file_value)) {
                unlink(public_path('/monitoring/value/').$value->file_value);
            }
            if($request->file_type == 'image') {
                $image = Image::make($file->path());
                $image->resize(720, 720, function($constraint) {
                    $constraint->aspectrRatio();
                })->save(public_path('/monitoring/value/').$filename);
            } else {
                $file->move(public_path('/monitoring/value'), $filename);
            }
            $data['file_value'] = $filename;
        }
        InputValue::query()->create($data);
        return redirect()->back()->with('message', 'Input Value Berhasil Diupdate')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $value = InputValue::query()->find($id);
        if(File::isDirectory(public_path('/monitoring/value/').$value->file_value) && $value->file_value != null) {
            unlink(public_path('/monitoring/value/').$value->file_value);
        }
        InputValue::query()->where('monitoring_input_id', $id)->delete();
        InputOption::query()->where('monitoring_input_id', $id)->delete();
        OptionValue::query()->where('monitoring_input_id', $id)->delete();
        $value->delete();
        return redirect()->back()->with('message', 'Input Value Berhasil Dihapus')->with('status', 'success');
    }
}
