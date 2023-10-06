<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NuevoUsuario;
use App\Mail\UsuarioRegistrado;
use App\Models\Partner;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'number' => ['required', 'exists:partners,number'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cfdi' => ['required'],
            'phone' => ['required', 'digits:10', 'integer'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required', 'integer', 'digits:5'],
            'line1' => ['required'],
            'line2' => ['required'],
            'reference' => ['nullable', 'string'],
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
        $users = User::where('role_id', 1)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new UsuarioRegistrado($data));
        }
        Mail::to($data['email'])->send(new NuevoUsuario($data));
        Mail::to($data['email'])->send(new NuevoUsuario($data));
        return User::create([
                'partner_id' => $data['number'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'cfdi' => $data['cfdi'],
                'phone' => $data['phone'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
                'line1' => $data['line1'],
                'line2' => $data['line2'],
                'reference' => $data['reference'],
                'role_id' => 3
            ]);
        Mail::to($data['email'])->send(new NuevoUsuario($data));

    }
}
