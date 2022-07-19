<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Code;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
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
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo(){
        return '/dashboard';
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255','exists:codes,code,child_id,NULL'],
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
$parent_gen = Code::where('code',$data['code'])->pluck('gen')->first();
// dd($parent_gen + 1);
    $user = User::create([
        'name' => $data['name'],
        'code' => $data['code'],
        'generation' => $parent_gen + 1,
        'phone' => $data['phone'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
    if(isset($user)){
        $code = Code::where('code',$data['code'])->first();
        $code->update(array('child_id' => $user->id));
            $role = Role::where('name', '=', 'customer')->firstOrFail();
            $user->attachRole($role);
            return $user;
    }



}
}
