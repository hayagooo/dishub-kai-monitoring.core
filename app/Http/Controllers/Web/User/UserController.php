<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\User\EditData;
use App\Jobs\User\Createdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query()
        ->when($request->get('name') != null, function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        })
        ->when($request->get('level') != null, function($query) use($request) {
            $query->where('level', $request->get('level'));
        })
        ->orderBy('id', $request->get('sort', 'DESC'))
        ->paginate(10);
        return Inertia::render('User/Index', ['users' => $users]);
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
            'code' => $request->code,
            'password' => $request->password,
            'level' => $request->level,
        ];
        CreateData::dispatch($data);
        User::query()->create($data);
        return redirect()->back()->with('message', 'Data pengguna baru berhasil disimpan')->with('status', 'success');
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
            'code' => $request->code,
            'password' => $request->password,
            'level' => $request->level,
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'code' => 'required',
            'level' => 'required',
            'password' => 'nullable|max:8'
        ];
        Validator::make($data, $rules)->validate();
        if($request->password == null || $request->password == '') {
            unset($data['password']);
            unset($rules['password']);
        }
        User::query()->where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Data pengguna berhasil diedit')->with('status', 'success');
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
        $users = User::find($id);
        $users->delete();
        return redirect()->back()->with('message', 'Data pengguna berhasil dihapus')->with('status', 'success');
    }
}
