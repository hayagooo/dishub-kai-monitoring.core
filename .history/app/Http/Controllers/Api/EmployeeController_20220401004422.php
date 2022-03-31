<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Employee\CreateData;
use App\Jobs\Employee\EditData;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::query()->with('team', 'monitoring')
            ->paginate($request->get('pagination', 10));
        return $this->jsonResponse($employees);
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
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'division' => $request->division,
            'branch' => $request->branch,
            'position' => $request->position,
            'profession' => $request->profession,
        ];
        CreateData::dispatch($data);
        $employee = Employee::query()->create($data);
        return $this->jsonResponse($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::query()->with('team', 'monitoring')->find($id);
        return $this->jsonResponse($employee);
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
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'division' => $request->division,
            'branch' => $request->branch,
            'position' => $request->position,
            'profession' => $request->profession,
        ];
        EditData::dispatch($data);
        $employee = Employee::query()->where('id', $id)->update($data);
        return $this->jsonResponse($employee);
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
