<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RunningPlan;
use App\UserRunningPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRunningPlanController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $id = $request->get('running_plan_id');

        $myGroupId = Auth::user()->group_id;
        $now = date("Y-m-d H:i:s");

        $rp_other_current = RunningPlan::where('group_id', $myGroupId)
            ->where('id', $id)
            ->where('end', '>', $now)
            ->where('start', '<=', $now)
            ->get();

        if ($rp_other_current->count() == 0) {
            return view("errors/403");
        }

	    $userId = Auth::user()->id;
        $runningPlan = RunningPlan::query()->findOrFail($id);

        UserRunningPlan::create([
            "user_id" => $userId,
            "running_plan_id" => $id,
            "start" => $now,
            "finish" => $runningPlan->end,
            "total_distance" => 0
        ]);

        return redirect()->route('running_plan.show', $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $userId = Auth::user()->id;
        $now = date("Y-m-d H:i:s");

        $rp_my_current = DB::table('user_running_plans')
            ->join('running_plans', 'user_running_plans.running_plan_id', '=', 'running_plans.id')
            ->where('user_running_plans.user_id', $userId)
            ->where('running_plans.id', $id)
            ->where('running_plans.end', '>', $now)
            ->where('running_plans.start', '<=', $now)
            ->get();

        if (empty($rp_my_current)) {
            return view("errors/403");
        }



        $userRunningPlan = UserRunningPlan::where('running_plan_id', $id)
            ->where('user_id', $userId);
        $userRunningPlan->delete();

        return redirect()->route('running_plan.show', $id);
	}

}
