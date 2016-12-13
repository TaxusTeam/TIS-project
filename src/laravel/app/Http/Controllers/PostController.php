<?php namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Postcontroller extends Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }


    public  function  index(){
        $names = User::all();

        //print ($names);
        //return $names;
        //return view('index')
 //           ->with('index',$names);
        return view("index", compact('names'));

    }

}
