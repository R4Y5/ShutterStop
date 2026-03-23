<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            auth()->logout();
            return redirect('/login')->with('error', 'Please verify your email before logging in.');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact_no' => ['required', 'string', 'max:20'],
            'address'    => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif'],
            'terms' => ['accepted'], // tems and conditions checkbox
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $photoPath = null;

        if (request()->hasFile('photo')) {
            $photoPath = request()->file('photo')->store('photos', 'public');
        }
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email' => $data['email'],
            'password'   => bcrypt($data['password']),
            'photo' => $photoPath,
            'contact_no' => $data['contact_no'],
            'address'    => $data['address'],
        ]);

        //automatically assign "customer" role to a new user
        $user->assignRole('customer');

        return $user;
    }
}
