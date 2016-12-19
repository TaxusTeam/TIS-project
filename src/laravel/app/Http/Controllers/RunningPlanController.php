<?php namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RunningPlan;
use App\UserRunningPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $userId = Auth::user()->id;
        $now = date("Y-m-d H:i:s");

	    if (Auth::user()->is_trainer) {

            $groups = Group::where('trainer_id', $userId)->orderBy('name')->lists('name', 'id');

	        $runningPlansCurrent = RunningPlan::where('owner_id', $userId)
                ->where('end', '>', $now)
                ->where('start', '<=', $now)
                ->orderBy('created_at', 'desc')
                ->get();

            $runningPlansOld = RunningPlan::where('owner_id', $userId)
                ->where('end', '<=', $now)
                ->orderBy('created_at', 'desc')
                ->get();

            $runningPlansFuture = RunningPlan::where('owner_id', $userId)
                ->where('start', '>', $now)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        else {
            $groups = Group::orderBy('name')->lists('name', 'id');

            $runningPlansCurrent = DB::table('user_running_plans')
                ->join('running_plans', 'user_running_plans.running_plan_id', '=', 'running_plans.id')
                ->where('user_running_plans.user_id', $userId)
                ->where('running_plans.end', '>', $now)
                ->where('running_plans.start', '<=', $now)
                ->orderBy('running_plans.created_at', 'desc')
                ->get([
                    'running_plans.*',
                    'user_running_plans.id AS user_running_plans___id',
                    'user_running_plans.created_at AS user_running_plans___created_at',
                    'user_running_plans.updated_at AS user_running_plans___updated_at',
                    'user_running_plans.user_id AS user_running_plans___user_id',
                    'user_running_plans.running_plan_id AS user_running_plans___running_plan_id',
                    'user_running_plans.start AS user_running_plans___start',
                    'user_running_plans.finish AS user_running_plans___finish',
                ]);

            $runningPlansOld = DB::table('user_running_plans')
                ->join('running_plans', 'user_running_plans.running_plan_id', '=', 'running_plans.id')
                ->where('user_running_plans.user_id', $userId)
                ->where('running_plans.end', '<=', $now)
                ->orderBy('running_plans.created_at', 'desc')
                ->get([
                    'running_plans.*',
                    'user_running_plans.id AS user_running_plans___id',
                    'user_running_plans.created_at AS user_running_plans___created_at',
                    'user_running_plans.updated_at AS user_running_plans___updated_at',
                    'user_running_plans.user_id AS user_running_plans___user_id',
                    'user_running_plans.running_plan_id AS user_running_plans___running_plan_id',
                    'user_running_plans.start AS user_running_plans___start',
                    'user_running_plans.finish AS user_running_plans___finish',
                ]);

            $myGroupId = Auth::user()->group_id;

            $rp_currentIds = [];
            foreach ($runningPlansCurrent as $rp) {
                $rp_currentIds[] = $rp->id;
            }

            $runningPlansFuture = RunningPlan::where('group_id', $myGroupId)
                ->where('end', '>', $now)
                ->where('start', '<=', $now)
                ->whereNotIn('id', $rp_currentIds)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('running_plans.index')
            ->with('title', 'Moje bežecké plány')
            ->with('groups', $groups)
            ->with('runningPlansCurrent', $runningPlansCurrent)
            ->with('runningPlansOld', $runningPlansOld)
            ->with('runningPlansFuture', $runningPlansFuture);
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

        if ($start < $end) {
            $timeAtomaticlalyAdjusted = false;
        }
        else {
            $timeAtomaticlalyAdjusted = true;
            $end = date("Y-m-d H:i:s", strtotime($start . "+1 days"));
        }

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

        Session::put('timeAtomaticlalyAdjusted', $timeAtomaticlalyAdjusted);

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
        $userId = Auth::user()->id;
	    $runningPlan = RunningPlan::query()->findOrFail($id);
        $timeAtomaticlalyAdjusted = Session::has('timeAtomaticlalyAdjusted') ? Session::get('timeAtomaticlalyAdjusted') : false;

        if (Auth::user()->is_trainer) {
            $check = RunningPlan::where('owner_id', $userId)
                ->where('id', $id)
                ->get()
                ->count() > 0;
        }
        else{
//            todo bezec
        }

        return view('running_plans.show')
            ->with('title', 'Môj bežecký plán')
            ->with('check', $check)
            ->with('runningPlan', $runningPlan)
            ->with('timeAtomaticlalyAdjusted', $timeAtomaticlalyAdjusted);
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
