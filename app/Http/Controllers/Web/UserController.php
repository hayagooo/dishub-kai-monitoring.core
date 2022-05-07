<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($data, $request->remember)) {
            $user = User::query()->find(Auth::id());
            return redirect()->route('index.verification')->with('message', 'Login berhasil: Verifikasi dahulu')
                ->with('status', 'success');;
        } else {
            return redirect()->back()->with('message', 'Login gagal: Email atau kata sandi tidak sesuai')
                ->with('status', 'failed');
        }
    }

    public function logout()
    {
        $user = User::query()->find(Auth::id());
        $user->verified_at = null;
        $user->save();
        Session::flush();

        return redirect()->route('home');
    }

    public function indexVerification()
    {
        $user = User::query()->find(Auth::id());
        return Inertia::render('Auth/Verify', ['user' => $user]);
    }

    public function verification(Request $request)
    {
        $data = [
            'code' => $request->code,
        ];
        Validator::make($data, [
            'code' => 'required',
        ]);
        $user = User::query()->find(Auth::id());
        if($user->code == $request->code) {
            $user->verified_at = Carbon::now();
            $user->save();
            return redirect()->route('dashboard')->with('message', 'Verifikasi Berhasil : Selamat datang kembali')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Kode verifikasi tidak sesuai')->with('status', 'failed');
        }
    }
}
