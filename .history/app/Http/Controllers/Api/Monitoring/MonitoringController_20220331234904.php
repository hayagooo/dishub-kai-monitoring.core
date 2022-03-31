<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Monitoring\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Monitoring::query()->with('employee', 'employee.team', 'team', 'image', 'input', 'input.option', 'categoryObject', 'categoryObject.category', 'categoryObject.object');
        $monitorings = $query->when($request->get('name') != null, function($queryMonitor) use($request) {
            $queryMonitor->where('name', 'LIKE', '%'.$request->get('name').'%');
        })->orderBy('created_at', $request->get('sort', 'ASC'))
        ->paginate($request->get('pagination', 10));
        return $this->jsonResponse($monitorings);
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
