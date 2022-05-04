<?php

namespace App\Http\Controllers\Web\Team;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Team;
use App\Jobs\Team\CreateData;
use App\Jobs\Team\EditData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::query()->with(['employee' => function($query){
            $query->where('employee_id', null);
        }])->get();
        return Inertia::render('Team/Index', ['teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $teamId = $request->get('teamId', Team::query()->first()->id);
        $employees = Employee::with(['team' => function($query) {
            $query->where('team_id', null);
        }])->get();
        $team = Team::query()->with('employee')->find($teamId);
        return Inertia::render('Team/Show', [
            'employees' => $employees,
            'teams' => $team,
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
        //
        $data = [
            'name' => $request->name,
            'description' => $request->descrition,
            'goals' => $request->goals,
            'note' => $request->note,
        ];
        CreateData::dispatch($data);
        Team::query()->create($data);
        return redirect()->back()->with('message', 'Data team baru berhasil disimpan')->with('status', 'success');

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
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'goals' => $request->goals,
            'note' => $request->note,
        ];
        $teams = Team::query()->find($id);
        EditData::dispatch($data);
        $teams->update($data);
        return redirect()->back()->with('message', 'Data team telah berhasil diubah')->with('status', 'success');
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
        $teams = Team::find($id);
        $teams->delete();
        return redirect()->back()->with('message', 'Data team telah berhasil dihapus')->with('status', 'success');
    }

    public function addEmployee()
    {
        Team::query()->find($id)->employee()->attach($request->employeeId);
        $teams = Team::query()->with('employee')->find($id);
        return redirect()->back()->with('message', 'Data Employee telah berhasil ditambahkan ke dalam Team')->with('status', 'success');

    }

    public function removeEmployee()
    {
        Team::query()->find($id)->employee()->detach($request->employeeId);
        $teams = Team::query()->with('employee')->find($id);
        return redirect()->back()->with('message', 'Data Employee telah berhasil dihapus dari Team')->with('status', 'success');
    }
}
