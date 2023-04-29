<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
            return view('layouts.backend_app');
        }
        $user = User::find(auth()->id());
        return response()->json($user);
    }
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::id(),
            'password' => 'sometimes|min:6',
        ]);
        $user = User::find(Auth::id());
        if($request->image != $user->image){
            $position = strpos($request->image, ';');
            $sub_str = substr($request->image, 0, $position);
            $ext = explode('/', $sub_str)[1];
            $imageName = time().'.'.$ext;
            $img = Image::make($request->image)->resize(320, 240);
            $image_path = public_path()."/uploads/images/profile/";
            $path = public_path("/uploads/images/profile/".$user->image);
            if(file_exists($path)){
                @unlink($path);
            }
            $img->save($image_path.$imageName);
            $request->merge(['image' => $imageName ]);
        }else{
            $imageName = $user->image;
        }
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request->password)]);
        }
        $user->update($request->all());

    }
}
