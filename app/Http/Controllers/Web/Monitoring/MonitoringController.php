<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\CreateData;
use App\Models\Employee;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\ObjectData;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', Category::query()->first()->id);
        $monitorings = Monitoring::query()
            ->with('category', 'object', 'team', 'employee', 'input')
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->paginate($request->get('pagination', 10));
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Index', [
            'monitorings' => $monitorings,
            'object' => $object,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', Category::query()->first()->id);
        $teams = Team::all();
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Create', [
            'object' => $object,
            'category' => $category,
            'teams' => $teams,
        ]);
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
            'employee_id' => $request->employee_id,
            'team_id' => $request->team_id,
            'title' => $request->title,
            'description' => $request->description,
        ];
        CreateData::dispatch($data);
        Monitoring::query()->create($data);
        return redirect()->back()->with('message', 'Data monitoring berhasil disimpan')->with('status', 'success');
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
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', Category::query()->first()->id);
        $teams = Team::all();
        $monitoring = Monitoring::query()->find($id);
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Edit', [
            'object' => $object,
            'monitoring' => $monitoring,
            'category' => $category,
            'teams' => $teams,
        ]);
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
