<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Team\CreateData;
use App\Jobs\Team\EditData;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        ->when($request->get('name') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        })
        ->orderBy('created_at', $request->get('sort', 'ASC'))
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
        $rules = [
            'name' => 'required',
        ];
        $data = [
            'name' => $request->name,
            'goals' => $request->goals,
            'note' => $request->note,
            'description' => $request->description,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
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
        $team = Team::query()->with('employee', 'monitoring')->find($id);
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
        $rules = [
            'name' => 'required',
        ];
        $data = [
            'name' => $request->name,
            'goals' => $request->goals,
            'note' => $request->note,
            'description' => $request->description,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Team::query()->where('id', $id)->update($data);
        $team = Team::query()->find($id);
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
        $rules = [
            'employeeId' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Team::query()->find($id)->employee()->attach($request->employeeId);
        $team = Team::query()->with('employee')->find($id);
        return $this->jsonResponse($team);
    }

    public function removeEmployee(Request $request, $id)
    {
        $rules = [
            'employeeId' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        Team::query()->find($id)->employee()->detach($request->employeeId);
        $team = Team::query()->with('employee')->find($id);
        return $this->jsonResponse($team);
    }
}
