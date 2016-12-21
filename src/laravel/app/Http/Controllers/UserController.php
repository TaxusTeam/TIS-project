<?php namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Request;

class UserController extends Controller {

    public function __construct()
    {

        $this->middleware('auth');

    }

    public  function  getInactive(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $names = User::all();
        return view("activate_user", compact('names'));
    }

    public  function  activateUser(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $data = Input::get('agree');

        if (sizeof($data) > 0 ) {
            $user = User::find($data);
            $user->is_active = 1;
            $user->save();
        }
        $names = User::all();
        return view("activate_user", compact('names'));
    }

    public  function  getAll(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $names = User::all();
        return view("delete_user", compact('names'));
    }

    public  function  deleteUser(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $data = Input::get('agree');

        if (sizeof($data) > 0 ) {
            $user = User::find($data);
            $user->delete();
        }
        $names = User::all();
        return view("delete_user", compact('names'));
    }

}
