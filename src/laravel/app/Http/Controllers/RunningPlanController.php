<?php namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RunningPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RunningPlanController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

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
	public function store(Request $request)
	{
	    $trainerId = Auth::user()->id;
        $origin = $request->get('origin');
        $destination = $request->get('destination');
        $start = date("Y-m-d H:i:s", strtotime($request->get('start')));
        $end = date("Y-m-d H:i:s", strtotime($request->get('end')));
        $description = $request->get('description');
        $name = $request->get('name');
        $group_id = $request->get('group_id');
        $distance_text = $_COOKIE["totalDistanceText"];
        $distance_value = $_COOKIE["totalDistanceValue"];
        $origin_lat = $_COOKIE["geoLocationOriginLat"];
        $origin_lng = $_COOKIE["geoLocationOriginLng"];
        $destination_lat = $_COOKIE["geoLocationDestinationLat"];
        $destination_lng = $_COOKIE["geoLocationDestinationLng"];

        $running_plan = RunningPlan::create([
            "owner_id" => $trainerId,
            "origin" => $origin,
            "destination" => $destination,
            "start" => $start,
            "end" => $end,
            "description" => $description,
            "name" => $name,
            "group_id" => $group_id,
            "distance_text" => $distance_text,
            "distance_value" => $distance_value,
            "origin_lat" => $origin_lat,
            "origin_lng" => $origin_lng,
            "destination_lat" => $destination_lat,
            "destination_lng" => $destination_lng,
        ]);

		return redirect()->route('running_plan.show', $running_plan->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$runningPlan = RunningPlan::query()->findOrFail($id);

        return view('running_plans.show')
            ->with('runningPlan', $runningPlan);
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
