<?php

namespace App\Http\Controllers\Auth;

use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Support\MessageBag;


class ProfileController extends Controller
{
	/**
	 * Show the user profile
	 *
	 * @param integer
	 * @return \Illuminate\Http\Response
	 */
    public function index() {
    	return view('auth/profile');
    }

    /**
	 * Update the user profile
	 *
	 * @param integer
	 * @return \Illuminate\Http\Response
	 */
    public function update(Request $request) {
    	$user = Auth::user();

    	// Check whether form data are correctly informed.
    	$emailValidator = ['required', 'string', 'email', 'max:255'];
    	$passwordValidator = [];

    	if($user->email !== $request->input('email'))
    		$emailValidator[] = 'unique:user';

    	if(!empty($request->input('password')))
    		$passwordValidator = ['string', 'min:6', 'confirmed'];

    	$validateData = $request->validate([
            'user_firstname' => ['required', 'string', 'max:255'],
            'user_lastname' => ['required', 'string', 'max:255'],
            'email' => $emailValidator,
            'password' => $passwordValidator,
            'user_phone_number' => ['string', 'min:10', 'max:10']
    	]);
    	////////////////////////////////////

    	// Update the current user data.
    	$user->user_firstname = $request->input('user_firstname');
    	$user->user_lastname = $request->input('user_lastname');
    	$user->user_phone_number = $request->input('user_phone_number');
    	$user->email = $request->input('email');

    	if(!empty($request->input('password'))) {
    		if($request->input('password') !== $request->input('password_confirmation')) {
    			return Redirect::back(); // Redirect to the same view.
    		}

    		else
    			$user->password = Hash::make($request->input('password'));
    	}
    	////////////////////////////////////

    	$user->update(); // Update the user in database with the new data.
    	Auth::user()->refresh(); // Update current user data from the database.

    	return Redirect::back()->withMessage('Profile updated successfully !');
    }
}
