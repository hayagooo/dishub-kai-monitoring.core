<?php

namespace App\Http\Controllers\Web\Monitoring;

use App\Exports\MonitoringExport;
use App\Http\Controllers\Controller;
use App\Jobs\Monitoring\CreateData;
use App\Jobs\Monitoring\EditData;
use App\Models\Employee;
use App\Models\Monitoring\Category;
use App\Models\Monitoring\Image;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputValue;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\ObjectData;
use App\Models\Monitoring\OptionValue;
use App\Models\Team;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
            ->when($request->get('title') != null, function($query) use($request) {
                $query->where('title', 'LIKE', '%'.$request->get('title').'%');
            })
            ->when($request->get('employee') != null, function($query) use($request) {
                $query->whereHas('employee', function($queryEmployee) use($request) {
                    $queryEmployee->where('name', 'LIKE', '%'.$request->get('employee').'%');
                });
            })
            ->with(['category', 'object', 'team', 'employee', 'input' => function($query) {
                $query->orderBy('sort_number', 'ASC');
            }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->orderBy('created_at', $request->get('sort', 'DESC'))
            ->paginate($request->get('pagination', 10));
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Index', ['monitorings' => $monitorings, 'category' => $category, 'object' => $object]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', ObjectData::query()->first()->id);
        $teams = Team::all();
        $inputs = [];
        $inputs['category'] = Input::query()->with('option')
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', null)
            ->get();
        $inputs['object'] = Input::query()->with('option')
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', null)
            ->get();
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        return Inertia::render('Monitoring/Create', [
            'object' => $object,
            'category' => $category,
            'inputs' => $inputs,
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
        $rules = [
            'monitoring_category_id' => 'required|exists:App\Models\Monitoring\Category,id',
            'monitoring_object_id' => 'required|exists:App\Models\Monitoring\ObjectData,id',
            'employee_id' => 'required|exists:App\Models\Employee,id',
            'team_id' => 'required|exists:App\Models\Team,id',
            'title' => 'required',
            'description' => 'nullable',
        ];
        Validator::make($data, $rules)->validate();
        $monitoring = Monitoring::query()->create($data);
        return redirect()->route('app.monitoring.edit', [
            'monitoring' => $monitoring->id,
            'categoryId' => $request->category_id,
            'objectId' => $request->object_id,
        ])->with('message', 'Data monitoring berhasil disimpan')->with('status', 'success')->withInput([
            'categoryId' => $request->category_id,
            'objectId' => $request->object_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $categoryId = $request->get('categoryId', Monitoring::query()->find($id)->monitoring_category_id);
        $objectId = $request->get('objectId', Monitoring::query()->find($id)->monitoring_object_id);
        $teams = Team::all();
        $menuIndex = $request->get('menu_index', 1);
        $inputs = [];
        $inputs['category'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        },
        'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['object'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }, 'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['monitoring'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }, 'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_id', $id)
            ->orderBy('sort_number', 'ASC')
            ->get();
        // return response()->json($inputs);
        $monitoring = Monitoring::query()->find($id);
        $object = ObjectData::query()->find($objectId);
        $images = Image::query()->where('monitoring_id', $id)->get();
        $employees = Employee::with('team')->whereHas('team', function($query) use($monitoring) {
            $query->where('team_id', $monitoring->team_id);
        })->orderBy('created_at', 'DESC')->get();
        $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
        $category = Category::query()->find($categoryId);
        // return response()->json($inputs);
        return Inertia::render('Monitoring/Show', [
            'object' => $object,
            'images' => $images,
            'token' => $token,
            'category' => $category,
            'inputs' => $inputs,
            'list_employee' => $employees,
            'menu_index' => $menuIndex,
            'teams' => $teams,
            'monitoring' => $monitoring,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', ObjectData::query()->first()->id);
        $teams = Team::all();
        $menuIndex = $request->get('menu_index', 1);
        $inputs = [];
        $inputs['category'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        },
        'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['object'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }, 'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['monitoring'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }, 'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', $id)
            ->orderBy('sort_number', 'ASC')
            ->get();
        // return response()->json($inputs);
        $monitoring = Monitoring::query()->find($id);
        $object = ObjectData::query()->find($objectId);
        $images = Image::query()->where('monitoring_id', $id)->get();
        $employees = Employee::with('team')->whereHas('team', function($query) use($monitoring) {
            $query->where('team_id', $monitoring->team_id);
        })->orderBy('created_at', 'DESC')->get();
        $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
        $category = Category::query()->find($categoryId);
        // return response()->json($inputs);
        return Inertia::render('Monitoring/Edit', [
            'object' => $object,
            'images' => $images,
            'token' => $token,
            'category' => $category,
            'inputs' => $inputs,
            'list_employee' => $employees,
            'menu_index' => $menuIndex,
            'teams' => $teams,
            'monitoring' => $monitoring,
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
        $data = [
            'monitoring_category_id' => $request->category_id,
            'monitoring_object_id' => $request->object_id,
            'employee_id' => $request->employee_id,
            'team_id' => $request->team_id,
            'title' => $request->title,
            'description' => $request->description,
        ];
        EditData::dispatch($data);
        $monitoring = Monitoring::query()->where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Data monitoring berhasil diedit')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Monitoring::query()->with('valueData', 'input', 'image', 'optionValue')->find($id);
        InputValue::query()->where('monitoring_id', $id)->delete();
        OptionValue::query()->where('monitoring_id', $id)->delete();
        Input::query()->where('monitoring_id', $id)->delete();
        Image::query()->where('monitoring_id', $id)->delete();
        $data->delete();
        return redirect()->back()->with('message', 'Data monitoring berhasil dihapus')->with('status', 'success');
    }

    public function export_excel(Request $request)
    {
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', ObjectData::query()->first()->id);
        $categoryId = $request->get('categoryId', $categoryId);
        $objectId = $request->get('objectId', $objectId);
        $object = ObjectData::query()->find($objectId);
        $category = Category::query()->find($categoryId);
        // $monitorings = Monitoring::query()->with('option', 'valueData', 'team', 'employee', 'object', 'category')->get;
        return (new MonitoringExport($categoryId, $objectId))->download('Monitoring Data-'.$category->name.'-'.$object->name.'.xlsx');
    }

    public function export_pdf(Request $request, $id)
    {
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        $categoryId = $request->get('categoryId', Category::query()->first()->id);
        $objectId = $request->get('objectId', ObjectData::query()->first()->id);
        $teams = Team::all();
        $menuIndex = $request->get('menu_index', 1);
        $inputs = [];
        $inputs['category'] = Input::query()->with(['option',
        'option.optionValue' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        },
        'valueData' => function($query) use($id) {
            $query->where('monitoring_id', $id);
        }])
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['object'] = Input::query()->with('option',  'option.optionValue', 'valueData')
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', null)
            ->orderBy('sort_number', 'ASC')
            ->get();
        $inputs['monitoring'] = Input::query()->with('option',  'option.optionValue', 'valueData')
            ->where('monitoring_category_id', $categoryId)
            ->where('monitoring_object_id', $objectId)
            ->where('monitoring_id', $id)
            ->orderBy('sort_number', 'ASC')
            ->get();
        // return response()->json($inputs);
        $monitoring = Monitoring::query()->find($id);
        $object = ObjectData::query()->find($objectId);
        $images = Image::query()->where('monitoring_id', $id)->get();
        $employees = Employee::with('team')->whereHas('team', function($query) use($monitoring) {
            $query->where('team_id', $monitoring->team_id);
        })->orderBy('created_at', 'DESC')->get();
        $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
        $category = Category::query()->find($categoryId);
        $logoBTP = base64_encode(file_get_contents(public_path('/images/').'logo-btp-jabar.png'));
        $logoDishub = base64_encode(file_get_contents(public_path('/images/').'logo-dishub.png'));
        $logoApp = base64_encode(file_get_contents(public_path('/images/').'logo.png'));
        $logoDev = base64_encode(file_get_contents(public_path('/images/').'logo-dev.png'));
        // return response()->json($inputs);
        $data_response =  [
            'object' => $object,
            'images' => $images,
            'token' => $token,
            'category' => $category,
            'inputs' => $inputs,
            'list_employee' => $employees,
            'menu_index' => $menuIndex,
            'teams' => $teams,
            'monitoring' => $monitoring,
            'logoBTP' => $logoBTP,
            'logoDishub' => $logoDishub,
            'logoApp' => $logoApp,
            'logoDev' => $logoDev,
        ];
        $pdf = Pdf::loadView('monitoring_pdf', $data_response);
        $pdfName = 'pdf-'.Str::slug($monitoring->title, '-').'-'.time().'-'.uniqid().'.pdf';
        return $pdf->download($pdfName);
    }
}
