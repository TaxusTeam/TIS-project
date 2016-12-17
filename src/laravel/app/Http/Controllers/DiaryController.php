<?php namespace App\Http\Controllers;
use App\Group;
use App\User;
use App\RunningData;
use App\UserRunningPlan;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;

class DiaryController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('diary');

	}

	public function create(){
		$userID = Auth::user()->id;
		(float)$distance = Input::get('distance');
		$date = Input::get('date');
		(int)$mood = Input::get('mood');
		$userRunningPlanID = 2;

		$userRunPlans = UserRunningPlan::where('user_id', $userID)->orderBy('running_plan_id')->lists('running_plan_id');
		foreach ($userRunPlans as $urp) {
			RunningData::create([
			'user_id' => $userID,
			'user_running_plan_id' => $urp,
			'date' => $date,
			'mood' => $mood,
			'distance' => $distance,
			]);
		}

		
		return view('diary');
	}

}

