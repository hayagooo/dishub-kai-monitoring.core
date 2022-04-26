<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Facades\Image;

class InputValueController extends Controller
{
    public function store(Request $request)
    {
        // Artisan::call('cache:clear');
        $data = [
            'monitoring_input_id' => $request->input_id,
            'type' => $request->type,
            'monitoring_id' => $request->monitoring_id,
            'string_value' => $request->string_value,
            'text_value' => $request->text_value,
            'date_value' => $request->date_value == null || $request->date_value == 'null' ? Carbon::now()->format('Y-m-d') : $request->date_value,
            'time_value' => $request->time_value == null || $request->time_value == 'null' ? Carbon::now()->format('H:i:s') : $request->time_value,
            'number_value' => $request->number_value,
            'file_value' => $request->file('file'),
            'type_file' => $request->type_file,
        ];
        $input = Input::query()->find($request->input_id);
        $extensionArray = ['image', 'media-youtube', 'description', 'file', 'radio', 'dropdown'];
        if(in_array($input->type, $extensionArray, true)) {
            return response()->json($input);
        }
        // if($input->type == 'date' || $input->type == 'time') {
        //     $data['number_value'] = 0;
        // }
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
        } else {
            unset($data['file_value']);
            unset($data['type_file']);
        }
        // return response()->json([$request->date_value, $request->date_value == null]);
        if($request->type == 'file') return;
        $input = Input::query()->find($request->input_id);
        if(($input->type != 'file' || $input->type != 'radio' || $input->type != 'image' || $input->type != 'dropdown' || $input->type != 'media-youtube' || $input->type != 'description') ) {
            Input::query()->find($request->input_id)->valueData()->delete();
            $input = InputValue::query()->create($data);
        }
        return response()->json($input);
    }
}
