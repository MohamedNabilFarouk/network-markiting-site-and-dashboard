<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        if(Auth::user()->hasRole('admin')){
            $codes= Code::paginate(10);
        }else{
            $codes= Code::where('parent_id',Auth::user()->id)->paginate(10);

        }
        $users = User::all();
        $ex_codes = Code::where([['child_id','NULL'],['updated_at','<', Carbon::now()->subDays(10)]])->get();
        $products = Product::all();
        $orders = Order::all();


        return view('admin.dashboard',compact('codes','users','ex_codes','products','orders'));
    }

}
