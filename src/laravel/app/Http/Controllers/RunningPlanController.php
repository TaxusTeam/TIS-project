<?php namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RunningPlanController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $trainerId = Auth::user()->id;
        $groups = Group::where('trainer_id', $trainerId)->orderBy('name')->lists('name', 'id');

		return view('running_plans.create')
            ->with('title', 'Nový bežecký plán')
            ->with('trainerId', $trainerId)
            ->with('groups', $groups);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return view('running_plans.store');
	}

    public function setMap()
    {
        Session::set("aa", $_POST["aa"]);
        Session::set("bb", $_POST["bb"]);
        Session::set("cc", $_POST["cc"]);
    }

    public function getMap()
    {
        return view('running_plans.getMap');
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
