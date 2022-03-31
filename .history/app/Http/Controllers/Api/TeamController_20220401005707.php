<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Team\CreateData;
use App\Jobs\Team\EditData;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = Team::query()->with('employee', 'monitoring')
            ->paginate($request->get('pagination', 10));
        return $this->jsonResponse($teams);
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
            'goals' => $request->goals,
            'note' => $request->note,
            'description' => $request->description,
        ];
        CreateData::dispatch($data);
        $team = Team::query()->create($data);
        return $this->jsonResponse($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::query()->with('team', 'monitoring')->find($id);
        return $this->jsonResponse($team);
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
            'name' => $request->name,
            'goals' => $request->goals,
            'note' => $request->note,
            'description' => $request->description,
        ];
        EditData::dispatch($data);
        $team = Team::query()->where('id', $id)->update($data);
        return $this->jsonResponse($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::query()->find($id);
        $team->delete();
        return $this->jsonResponse($team);
    }

    public function addEmployee(Request $request, $id)
    {
        $team = Team::query()->with('employee')->find($id);
        $team->employee()->attach($request->employeeId);
        retuen
    }
}
