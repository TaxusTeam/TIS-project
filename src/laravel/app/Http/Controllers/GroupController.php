<?php namespace App\Http\Controllers;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;

//use Illuminate\Support\Facades\Request;

class GroupController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this -> wasPressed = 0;

    }

    public function index()
    {
        $names = User::all();
        return view("createGroup", compact('names'));
    }

    public  function  create(){

        $users = collect(Input::get('agree'));
        $groupName = Input::get('groupName');
        $trainerId = Auth::user()->id;

        Group::create([
            'name' => $groupName,
            'trainer_id' => $trainerId,
        ]);

        $groupId = Group::orderBy('created_at', 'desc')->first()->id;

        foreach ($users as $userId){
            $user = User::find($userId);
            $user->group_id = $groupId;
            $user->save();
        }

        $names = User::all();

        return view("createGroup",compact('names'));
    }

    public function getToDelete(){
        $names = Group::all();
        return view("deleteGroup",compact('names'));
    }

    public function delete(){
        $groupId = Input::get('agree');

        $grp = Group::where('id', $groupId)->first();
        $grp->delete();

        $users = User::all();

        foreach ($users as $user){
            if ($user->group_id == $groupId){
                $user->group_id = 0;
                $user->save();
            }
        }
        $names = Group::all();
        return view("deleteGroup",compact('names'));

    }

    public function getToEdit(){

        $trainerId = Auth::user()->id;
        $items = Group::where('trainer_id', $trainerId)->orderBy('name')->lists('name', 'id');

        return view("editGroup",compact('id','items'));
    }

    public function edit(){
        $action = Input::get('action', 'none');
        //print($action);
        if($action=='Edit'){
            $groupName = Input::get('group');
            $grp = Group::where('id', $groupName)->first();
            $names = User::all();

            return view("editSelectedGroup", compact('grp', 'names'));

        }else if($action=='Save'){
            //do save
            //print("it works");
            $usersToAdd = collect(Input::get('agreeAdd'));
            $usersToDel = collect(Input::get('agreeDel'));
            $newName = Input::get('grp_name');
            $groupId = Input::get('id');


            $grp = Group::where('id', $groupId)->first();
            $grp->name = $newName;
            $grp->save();


            foreach ($usersToAdd as $user){
                $users = User::where('id', $user)->first();
                $users->group_id =  $groupId;
                $users->save();
            }

            foreach ($usersToDel as $user){
                $users = User::where('id', $user)->first();
                $users->group_id = 0;
                $users->save();
            }

            /** Vrati sa na povodny vyber skupiny*/

            $trainerId = Auth::user()->id;
            $items = Group::where('trainer_id', $trainerId)->orderBy('name')->lists('name', 'id');

            return view("editGroup",compact('id','items'));

        }

    }
    
}
