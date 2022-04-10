<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\ObjectData;
use Illuminate\Http\Request;
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
        $inputs = Input::query()->with('monitoring', 'option', 'category', 'object')
        ->when($request->get('categoryId') != null, function($query) use($request) {
            $query->where('monitoring_category_id', $request->get('categoryId'));
        })
        ->when($request->get('objectId') != null, function($query) use($request) {
            $query->where('monitoring_object_id', $request->get('objectId'));
        })
        ->when($request->get('monitoringId') != null, function($query) use($request) {
            $query->where('monitoring_id', $request->get('monitoringId'));
        })->get();
        return Inertia::render('Monitoring/Input/Index', ['inputs' => $inputs, 'datas' => $datas]);
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
        //
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
}
