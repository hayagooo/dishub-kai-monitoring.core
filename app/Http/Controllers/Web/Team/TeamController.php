<?php

namespace App\Http\Controllers\Web\Team;

use App\Exports\TeamExport;
use App\Http\Controllers\Controller;
use App\Imports\TeamImport;
use App\Models\Employee;
use App\Models\Team;
use App\Jobs\Team\CreateData;
use App\Jobs\Team\EditData;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\Monitoring;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = Team::query()
        ->with('employee')
        ->when($request->get('name') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        });
        $exploding = explode("-", $request->get('sort', 'id-desc'));
        if($exploding[0] == 'id') $teams->orderBy('id', $exploding[1]);
        else $teams->withCount('employee')->orderBy('employee_count', $exploding[1]);
        $data = $teams->paginate(10);
        $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
        $employees = Employee::query()->when($request->get('name_employee') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name_employee').'%');
        })->with('team')->get();
        return Inertia::render('Team/Index', ['teams' => $data, 'employees' => $employees, 'token' => $token]);
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
            'description' => $request->description,
            'goals' => $request->goals,
            'note' => $request->note,
        ];
        $rules = [
            'name' => 'required|max:100',
            'description' => 'nullable',
            'goals' => 'nullable',
            'note' => 'nullable',
        ];
        Validator::make($data, $rules)->validate();
        Team::query()->create($data);
        return redirect()->back()->with('message', 'Data team baru berhasil disimpan')->with('status', 'success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $name = str_replace('-', ' ', $request->get('name'));
        $employees = Employee::query()->when($request->get('name_employee') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name_employee').'%');
        })->with('team')->paginate(10);
        $team = Team::query()->with('employee')->where('id', $id)->orWhere('name', 'LIKE', '%'.$name.'%')->first();
        return Inertia::render('Team/Show', ['team' => $team, 'employees' => $employees, 'team_name' => $name]);
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
        $rules = [
            'name' => 'required|max:100',
            'description' => 'nullable',
            'goals' => 'nullable',
            'note' => 'nullable',
        ];
        Validator::make($data, $rules)->validate();
        $teams = Team::query()->find($id);
        EditData::dispatch($data);
        $teams->update($data);
        return redirect()->back()->with('message', 'Data team berhasil diedit')->with('status', 'success');
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
        return redirect()->back()->with('message', 'Data team berhasil dihapus')->with('status', 'success');
    }

    public function addEmployee(Request $request, $id)
    {
        $team = Team::query()->with('employee')->find($id);
        $team->employee()->detach();
        foreach (json_decode($request->data) as $item) {
            if($item->checked) {
                $team->employee()->attach($item->item->id);
            }
        }
        return redirect()->back()->with('message', 'Pegawai berhasil disimpan')->with('status', 'success');
    }

    public function removeEmployee(Request $request, $id)
    {
        $rules = [
            'employeeId' => 'required',
        ];
        Validator::make($request->all(), $rules)->validate();
        Team::query()->find($id)->employee()->detach($request->employeeId);
        Team::query()->with('employee')->find($id);
        return redirect()->back()->with('message', 'Pegawai berhasil dihapus')->with('status', 'success');
    }

    public function exportExcel()
    {
        $excelName = 'excel-team-'.time().'.xlsx';
        return Excel::download(new TeamExport, $excelName);
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
            $this->destroyAll();
        }
        Excel::import(new TeamImport, $request->file('document'));
        return redirect()->back()->with('message', 'Import data tim berhasil')->with('status', 'success');
    }

    public function destroyAll()
    {
        $teams = Team::query()->get();
        foreach($teams as $item) {
            $team = Team::query()->with(['employee', 'monitoring'])->find($item->id);
            $monitorings = Monitoring::query()->where('team_id', $team->id)->get();
            if($monitorings != null && count($monitorings) > 0) {
                foreach($monitorings as $item) {
                    $monitoring = Monitoring::query()->find($item->id);
                    $monitoring->image()->delete();
                    if($monitoring->input()->get() != null && count($monitoring->input()->get()) > 0) {
                        foreach($monitoring->input()->get() as $input_item) {
                            $input = Input::query()->find($input_item->id);
                            $input->valueData()->delete();
                            $input->option()->delete();
                            $input->optionValue()->delete();
                        }
                    }
                    $monitoring->input()->delete();
                    $monitoring->valueData()->delete();
                    $monitoring->optionValue()->delete();
                    $monitoring->delete();
                }
            }
            $team->employee()->detach();
            $team->delete();
        }
        return redirect()->back()->with('message', 'Hapus data tim berhasil')->with('status', 'success');
    }
}
