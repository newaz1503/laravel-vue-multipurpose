<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $query =  $request->get('q');
        if(!empty($query)){
            $users = User::where('name', 'LIKE', "%$query%")
            ->Where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('type', 'LIKE', "%$query%")
            ->get();
            // $users = User::where(function($s) use ($query){
            //     $s->where('name', 'LIKE', "%$query%")
            //     ->orWhere('email', 'LIKE', "%$query%")
            //     ->orWhere('type', 'LIKE', "%$query%")
            //     ->get();
            // });
        }else{
            $users = User::orderBy('id', 'desc')->get();
        }
        return $users;
    }
}
