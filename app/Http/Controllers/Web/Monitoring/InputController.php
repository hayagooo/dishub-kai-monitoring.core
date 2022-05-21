<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\ObjectData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class InputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = [];
        if($request->has('categoryId')) {
            $datas['category'] = Category::query()->find($request->get('categoryId'));
        }
        if($request->has('objectId')) {
            $datas['object'] = ObjectData::query()->find($request->get('objectId'));
        }
        if($request->get('monitoringId')) {
            $datas['monitoring'] = Monitoring::query()->find($request->get('monitoringId'));
        }
        if($request->get('categoryId') != null && $request->get('categoryId')) {
            $inputs = Input::query()->with('monitoring', 'option', 'category', 'object')
            ->when($request->get('categoryId') != null, function($query) use($request) {
                $query->where('monitoring_category_id', $request->get('categoryId'));
                $query->where('monitoring_object_id', $request->get('objectId', null));
            })->orderBy('sort_number', 'ASC')->get();
        }
        if($request->get('objectId') && $request->get('objectId')) {
            $inputs = Input::query()->with('monitoring', 'option', 'category', 'object')
            ->when($request->get('objectId') != null, function($query) use($request) {
                $query->where('monitoring_object_id', $request->get('objectId', ObjectData::query()->first()->id));
                $query->where('monitoring_id', $request->get('monitoringId', null));
            })->orderBy('sort_number', 'ASC')->get();
        }
        if($request->get('monitoringId') && $request->get('monitoringId')) {
            $inputs = Input::query()->with('monitoring', 'option', 'category', 'object')
            ->when($request->get('monitoringId') != null, function($query) use($request) {
                $query->where('monitoring_id', $request->get('monitoringId', Monitoring::query()->first()->id));
            })->orderBy('sort_number', 'ASC')->get();
        }
        $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
        return Inertia::render('Monitoring/Input/Index', ['inputs' => $inputs, 'datas' => $datas, 'token' => $token]);
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
            'monitoring_category_id' => $request->category_id,
            'monitoring_object_id' => $request->object_id,
            'monitoring_id' => $request->monitoring_id,
            'image' => $request->file('image'),
            'is_required' => $request->is_required,
            'label' => $request->label,
            'type' => $request->type,
            'placeholder' => $request->placeholder,
            'description' => $request->description,
        ];
        Input::query()->create($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download(Request $request)
    {
        $input = Input::query()->find($request->get('id'));
        return Response::download(public_path('/monitoring/input/').$input->image);
    }
}
