<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
            return view('layouts.backend_app');
        }
        $user = User::orderBy('id', 'desc')->get();
        return response()->json($user);
    }
    public function store(Request $request){
        $this->validate($request, [
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        User::create([
            'type' => $request->type,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
        ]);
        return response()->json([
            'msg' => 'user stored'
        ]);
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes',
        ]);
        User::where('id', $request->id)->update([
            'type' => $request->type,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
        ]);
        return response()->json([
            'msg' => 'user updated'
        ]);
    }

    public function delete($id){
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'msg' => 'user deleted'
        ]);
    }
}
