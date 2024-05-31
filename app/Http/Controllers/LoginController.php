<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //


    public function index()
    {
        return view('login'); // Adjust as necessary
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'utype' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return redirect('signup')
                ->withErrors($validator)
                ->withInput();
        }



        //eloquent new user save
        // Create a new user instance and save it to the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password before saving
            'utype' => $request->utype
        ]);


        // Optionally, log the user in after registration
        auth()->login($user);


        // Redirect to the intended page or a default page
        return redirect()->intended('dashboard'); // Adjust as necessary

    }

    public function loginUser(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to intended page or default to dashboard
            return redirect()->intended('dashboard'); // Adjust as necessary
        }

        // If authentication fails, redirect back with an error message
        return redirect('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function dashboard()
    {
        $user = Auth::user(); // Get the authenticated user

        if($user->utype == "teacher"){
            return view('teacher/dashboard', compact('user')); // Pass the user to the view

        }
        else{
            return view('learner/dashboard', compact('user')); // Pass the user to the view

        }

    }


    public function signup()
    {
        return view('signup'); // Adjust as necessary
    }

    public function logout()
    {
        Auth::logout(); // Logout the user
        return redirect('/'); // Redirect to the homepage or login page
    }
}
