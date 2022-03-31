<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\Object\CreateData;
use App\Models\Monitoring\ObjectData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ObjectDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ObjectData::query();
        $objects = $query->when($request->category_id != null, function($query, $request) {
            $query->where('category_id', $request->get('category_id', 1));
        })->get();
        $this->jsonResponse($objects);
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
            'name' => $request->name,
            'icon' => $request->file('icon'),
            'description' => $request->description,
        ];
        CreateData::dispatch($data);
        if($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = 'object-'.Str::slug($request->name).'-'.uniqid().'.'.$icon->extension();
            $this->checkDirectory('/monitoring/icon');
            $icon->move(public_path('/monitoring/icon/'), $iconName);
            $data['icon'] = $iconName;
        }
        $object = ObjectData::query()->create($data);
        $this->jsonResponse($object);
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
