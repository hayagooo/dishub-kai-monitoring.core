<?php

namespace App\Http\Controllers\Web\User\Employee;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Jobs\Employee\CreateData;
use App\Jobs\EMployee\EditData;
use App\Models\Monitoring\Image;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputValue;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $employees = Employee::query()
        ->with('team')
        ->when($request->get('name') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        })
        ->orderBy('id', $request->get('sort', 'DESC'))
        ->paginate(10);
        return Inertia::render('User/Employee/Index', ['employees' => $employees]);
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
        Employee::query()->create($data);
        return redirect()->back()->with('message', 'Data Kategori baru berhasil disimpan')->with('status', 'success');
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
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'division' => $request->division,
            'branch' => $request->branch,
            'position' => $request->position,
            'profession' => $request->profession,
        ];
        $employee = Employee::query()->find($id);
        EditData::dispatch($data);
        $employee->update($data);
        return redirect()->back()->with('message', 'Data Kategori baru berhasil disimpan')->with('status', 'success');
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
        $employees = Employee::query()->with('team', 'monitoring')->find($id);
        $employees->team()->sync([]);
        $monitoringIds = [];
        foreach($employees->monitoring as $item) {
            $monitoringIds[] = $item->id;
            $data = Monitoring::query()->find($item->id);
            InputValue::query()->where('monitoring_id', $item->id)->delete();
            OptionValue::query()->where('monitoring_id', $item->id)->delete();
            Input::query()->where('monitoring_id', $item->id)->delete();
            Image::query()->where('monitoring_id', $item->id)->delete();
            $data->delete();
        }
        $employees->delete();
        return redirect()->back()->with('message', 'Data objek berhasil dihapus')->with('status', 'success');
    }

    public function exportExcel()
    {
        $excelName = 'excel-employee-'.time().'.xlsx';
        return Excel::download(new EmployeeExport, $excelName);
    }

    public function importExcel(Request $request)
    {
        $data = [
            'document' => $request->file('document'),
        ];
        $rules = [
            'document' => 'required|mimes:xlsx,xls'
        ];
        Validator::make($data, $rules)->validate();
        $is_reset = (int) $request->is_reset;
        if($is_reset == 1) {
            $employees = Employee::query()->get();
            foreach($employees as $item) {
                $employee = Employee::query()->with('team')->find($item->id);
                $employee->team()->sync([]);
                Monitoring::query()->where('team_id', $item->id)->delete();
                $employee->delete();
            }
        }
        Excel::import(new EmployeeImport, $request->file('document'));
        return redirect()->back()->with('message', 'Import data berhasil')->with('status', 'success');
    }

    public function destroyAll()
    {
        $employees = Employee::query()->get();
        foreach($employees as $item) {
            $employee = Employee::query()->with('team')->find($item->id);
            $employee->team()->sync([]);
            Monitoring::query()->where('team_id', $item->id)->delete();
            $employee->delete();
        }
        return redirect()->back()->with('message', 'Hapus data berhasil')->with('status', 'success');
    }
}
