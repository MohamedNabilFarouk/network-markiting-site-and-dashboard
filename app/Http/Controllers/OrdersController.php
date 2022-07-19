<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Order;
use App\Code;
use App\User;
use App\Product;
use Auth;
use Str;
use DB;


// use App\OrderItem;


class OrdersController extends Controller
{

    public function index()
    {

        $orders = Order::orderBy('id','DESC')->paginate(10);

        return view('admin.order.index', compact('orders'));
    }

    public function store($request=[]){
        // $data = $request -> validate([
        //     'name' => 'required|string|max:100',
        //     'phone' => 'string',
        //     'address' => 'string|required',
        // ]);
        // dd($request);
    $product = Product::findOrFail($request['product_id']);
        $order = Order::create([
                'product_id'        =>$product->id,
                'user_id'               =>Auth::user()->id,
                'merchantRefNumber'=> $request['merchantRefNumber'],
                'total'        =>$product->price,
                'is_paid'               =>0,
                'payment_method'        =>'cash',
                'name'                  =>$request['name'],
                'address'                  =>$request['address'],
                'phone'                  =>$request['phone'],
                'code'                  =>$request['code'],
            ]);

            if(isset($order)){
                //    $codes= $this->codeGenerator();
                    // return view('admin.generatedCodes',compact('codes'));
                    // return ['order'=>$order->id,'codes'=>$codes];
                    return [$order->id];
                }
    }

    public function codeGenerator($user_id){

        $auth_user = User::find($user_id);
        // dd($auth_user);
        $register_code= $auth_user->code;



        //  dd($register_code);

        $parent_id='';
        $parent_id = substr($register_code, strpos($register_code, "#") + 1);
        // dd($parent_id);
// dd($whatIWant);
        for($i=0; $i<=2; $i++){
            $string = Str::random(8);
            // $code[] = $auth_user->name.'#'.$auth_user->generation.'%'.$string;
             $code = $string.'%G'.$auth_user->generation.'&#'.$auth_user->id.'#P'.$parent_id;
             $count= substr_count($code,"#");
            if($count > 6){
                // dd($code);
                // $after = substr($code, strpos($code, '#', -3));
                 $test = explode('#', $code);
                 $after = end($test);
                $new = str_replace($after,'',$code);
                $code_new = substr($new , 0 , -1);
                // dd($code_new);
               }else{
                   $code_new = $string.'%G'.$auth_user->generation.'&#'.$auth_user->id.'#P'.$parent_id;
                   
               }
               
            Code::create(array(
                'parent_id'=>$auth_user->id,
                // 'code'=>$string.'%G'.$auth_user->generation.'&#'.$auth_user->id.'#P'.$parent_id,
                'code'=>$code_new,
                'gen'=>(int)$auth_user->generation,
            ));
        }

       return $code;
        // dd($code);


    }

    public function checkout($product_id){

        $product =Product::findOrFail($product_id);
        // dd($product);
        return view('site.checkout')->withProduct($product);
    }
    public function expiredCodes(){
        $codes = Code::where([['child_id','NULL'],['updated_at','<', Carbon::now()->subDays(10)]])->get();
        dd($codes);
    }



    public function destroy($id)
    {
        $order = Order ::find($id);

        DB::beginTransaction();

     
        $order-> delete();

        DB::commit();

        session() -> flash('success', trans('deleted successfully'));
        return redirect() -> route('order.index');
    }





}
