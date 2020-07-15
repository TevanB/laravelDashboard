<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\ClientNewRegistrationMail;

use Illuminate\Support\Facades\Mail;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        $user = User::create([
            'id' => $data['id'],
            'ongoing_orders_arr' => json_decode($data['ongoing_orders_arr']),
            'current_orders_arr' => json_decode($data['current_orders_arr']),

            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $curl2 = curl_init();
        $hookObject = json_encode([
          "type" => "rich",
          "content" => "User: ".$user->name.", Email: ".$user->email." has registered on your site.",
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        curl_setopt_array($curl2, [
          CURLOPT_URL => 'https://discordapp.com/api/webhooks/732698435324477525/zSq2-7HQLwZ-9a1zqraq_pdR9xeKzilNwkErT_n7AXs3fLfZmo8CmXo9piJxBubRExzw',
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => $hookObject,
          CURLOPT_HTTPHEADER => [
              "Content-Type: application/json"
            ]
        ]);
        curl_exec($curl2);
        curl_close($curl2);
        Mail::to($user->email)->send(new ClientNewRegistrationMail());
        $token = User::findOrFail($data['id'])->createToken('API ACCESS')->accessToken;
        $user2 = User::findOrFail($data['id']);

        $user2->SendEmailVerificationNotification();

        return $user;
    }
}
