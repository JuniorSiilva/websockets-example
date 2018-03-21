<?php

namespace WebSocketDashboard\Http\Controllers;

use Illuminate\Http\Request;
use WebSocketDashboard\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use WebSocketDashboard\Events\UserRegistered;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('storeUser');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['users' => User::orderBy('id', 'desc')->get()->except(Auth::id())]);
    }

    public function storeUser(Request $request, User $user){
        $rules = Validator::make($request->all(), [
            'name' => 'present|required|string|max:100',
            'email' => 'present|required|string|max:100|email|unique:users,email',
            'password' => 'present|required|string'
        ]);

        if($rules->fails()) return response()->json(['errors' => $rules->errors()]);
        
        $user = $user->create($request->only(['name', 'email', 'password']));

        event(new UserRegistered($user));
    }
}
