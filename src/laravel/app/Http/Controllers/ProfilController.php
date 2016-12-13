<?php namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Intervention\Image\Facades\Image;

use Symfony\Component\HttpFoundation\Tests\Session\Storage\Proxy\AbstractProxyTest;

class ProfilController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
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
		$names = User::all();
		$userID = Auth::id();

		return view('profil', compact('names','userID'));

	}

	/**
	 * @param Request $request
	 * @return \Illuminate\View\View
     */
	public function update_avatar(Request $request)
	{
		//print (File::get($request));
		if($request->hasFile('avatar')){ //.jpg
			$avatar = $request->file('avatar');
			$filename = time() . '.jpg'; //. $avatar->getClientOriginalExtensions();
			Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/' . $filename));


            $user = Auth::user();
			$user -> avatar = $filename;
			$user ->save();
		}

		$names = User::all();
		$userID = Auth::id();

		return view('profil', compact('names','userID'));

	}
}

