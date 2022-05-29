<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\User\CreateData;
use App\Jobs\User\EditData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            ->when($request->get('name'), function($query) use($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })->orderBy('created_at', $request->get('sort', 'ASC'))
            ->paginate($request->get('pagination', 10));
        return $this->jsonResponse($users);
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
            'code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ];
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'level' => $request->level,
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        $user = User::query()->create($data);
        return $this->jsonResponse($user);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()->find($id);
        return $this->jsonResponse($user);
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
            'code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'level' => 'required',
        ];
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'level' => $request->level,
        ];
        if($request->password == null || $request->password == '')
            unset($data['password']);

        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        EditData::dispatch($data);
        User::query()->where('id', $id)->update($data);
        $user = User::query()->find($id);
        return $this->jsonResponse($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::query()->find($id);
        $user->delete();
        return $this->jsonResponse($user);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        if(Auth::attempt($data, $request->remember != null ? $request->remember : false)) {
            $user = Auth::guard('api')->user();
            $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->jsonResponse($response);
        } else {
            return $this->jsonResponse([
                'message' => 'Login Tidak Berhasil',
            ], 200, 'FAILED');
        }
    }

    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if($validator->fails()) {
            return $this->jsonResponse([
                'messages' => $validator->errors(),
            ], 400, 'FAILED');
        }
        if(Auth::guard('api')->check() && (Auth::guard('api')->user()->code == $request->code)) {
            $user = Auth::guard('api')->user();
            $token = User::find(Auth::guard('api')->id())->createToken('authentification')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->jsonResponse($response);
        } else {
            return $this->jsonResponse([
                'message' => 'Verifikasi gagal: kode tidak cocok',
            ], 200, 'FAILED');
        }
    }

    public function logout()
    {
        return $this->jsonResponse([
            'message' => 'Logout Berhasil'
        ], 200, 'FAILED');
    }
}
