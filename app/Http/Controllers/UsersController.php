<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Code;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Provider;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;


class UsersController extends Controller
{
    //
    public function index(){
        $roles= Role::all();
        $users = User::all();
        // dd($users);
        return view('admin.user.index',compact('users','roles'));
    }

    public function userCode(){
        if(Auth::user()->hasRole('admin')){
            $codes= Code::paginate(10);
        }else{
            $codes= Code::where('parent_id',Auth::user()->id)->paginate(10);

        }

        return view('admin.yourCodes',compact('codes'));
    }

    // public function create(){
    //     $roles= Role::all();

    //     // dd($users);
    //     return view('admin.user.create',compact('roles'));
    // }

    // protected function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'phone' => ['required', 'string', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],

    //     ]);
    //     // dd($data['password']);
    //     $data['password'] = Hash::make($data['password']);
    //     $user =  User::create($data);
    //     $user->attachRole($request->role); // customer default


    //     // if($request->role == 3 ){
    //     //     session()->flash('success', trans('validation.User Added Successfully, Please Fill Delivery Information'));
    //     //     return redirect()->route('deliveryBoy.create');
    //     // } else {
    //         session()->flash('success', trans('validation.added successfully'));
    //         return redirect()->route('user.index');
    //     // }

    // }


    public function addRole(){
        $role = 4;
        $id = 4;
        $user = User::find($id);
        // $user->attachRole($role);
        $user->roles()->attach([$role]);
        dd($user);
    }


    public function edit($id){
        $user = User::findOrFail($id);
        $roles= Role::all();
        return view ('admin.user.edit',compact('user','roles'));
    }

    public function update(Request $request,$id){

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        //   'phone' => ['required', 'string', 'max:255', 'unique:users,phone,'.$id],
          'phone' => ['required', 'string', 'max:255'],


        ]);
        $user = User::find($id);
        $data['password'] = Hash::make($request->password);
        $data['balance'] = $request->balance;
        $code = Code::where('parent_id',$user->id)->get();
        $user->update($data);
        foreach($code as $c){
            $c->updated_at = Carbon::now();
            $c->save();
        }


        session()->flash('success', trans('validation.Updated Successfully'));
            return redirect()->route('user.index');

    }



    public function editUserRole( Request $request){
        // $role = 5;
        //  $id = 4;
        // dd($user->roles[0]->name);
        $user = User::find($request->id);
        $user->detachRole($user->roles[0]->id); // parameter can be a Role object, array, id or the role string name
         $user->attachRole($request->role);
        // $user->roles()->attach(['customer']);
        session()->flash('success', trans('Updated successfully'));
        return redirect()->route('user.index');
    }



    public function getChangePass(){
       
        return view('admin.user.changePass');
    }

    public function changePass(Request $request)

    {

        $request->validate([

            'old_password' => ['required'],

            'new_password' => ['required','confirmed'],


        ]);

        if ((Hash::check($request->get('old_password'), Auth::user()->password))) {
    User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)
    ]);
$user = User::find(auth()->user()->id);

    // dd($user);
    $user->updated_at = $user->created_at;
    $user->save();
        session()->flash('success', trans('updated successfully'));
        }else{
            session()->flash('Error', trans('Error In Old Password'));
        }

        
        return redirect()->route('dashboard');
    }






    public function filter(Request $request){
        $roles= Role::all();
        $users = User::where('generation', $request->gen)->get();
        //  dd($users);
        return view('admin.user.index',compact('users','roles'));

    }


    public function destroy( $id){

        $user = User::find($id);
        // $user_provider = Provider::where('user_id',$id)->get();
        DB::beginTransaction();
        $user->detachRole($user->roles[0]->name); // parameter can be a Role object, array, id or the role string name
         $user->delete();
        //  foreach($user_provider as $u){
        //     $u->delete();
        //  }

         DB::commit();
        // $user->roles()->attach(['customer']);

        session()->flash('success', trans('deleted successfully'));
        return redirect()->route('user.index');
    }
}
