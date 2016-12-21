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

class TrainersController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function  index(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $names = User::all();
        return view("addtrainers", compact('names'));
    }

    public  function  indexRemove(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $names = User::all();
        return view("rmtrainers", compact('names'));
    }

    public  function  update_to_trainer(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $data = Input::get('agree');

        if (sizeof($data) > 0 ) {
            $user = User::where('email', $data)->first();
            $user->is_trainer = true;
            $user->save();
        }
        $names = User::all();
        return view("addtrainers", compact('names'));
    }

    public  function  remove_trainer(){
        if (Auth::user()->is_admin != true){
            return view("forbidden");
        }

        $data = Input::get('disagree');

        if (sizeof($data) > 0 ) {
            $user = User::where('email', $data)->first();
            $user->is_trainer = false;
            $user->save();
        }
        $names = User::all();
        return view("rmtrainers", compact('names'));
    }

}
