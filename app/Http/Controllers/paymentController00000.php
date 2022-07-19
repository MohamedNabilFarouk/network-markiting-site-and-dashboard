<?php

namespace App\Http\Controllers;

use App\Code;
use Illuminate\Http\Request;
use Guzzle\Http\Client;
use GuzzleHttp\Psr7;
use Session;
use Carbon\Carbon;
use DB;
use MTGofa\FawryPay\FawryPay;
use App\Http\Controllers\OrdersController;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;


class paymentController extends Controller
{

    public function generate(Request $request){
        // save order

         $request -> validate([
            'name' => 'required|string|max:100',
            'phone' => 'string',
            'address' => 'string|required',
            'code' => 'required|unique:orders',
        ]);
        if($request['code'] != Auth::user()->code ){
            session() -> flash('Error', trans('Code Not Matched with your code'));
        return redirect() -> back();
        }
        $order =  app('App\Http\Controllers\OrdersController')->store($request->all());
        $product = Product::findOrFail($request->product_id);
        //   dd($product);
         Session::put('order_id', $order);

        // payment
        $fawryPay = new FawryPay;
        // dd($fawryPay);
        //optional if you have the customer data
    $fawryPay->customer([
    	'customerProfileId' => Auth::user()->id,
    	'name'              => $request->name,
        'email'             => Auth::user()->email,
    	'mobile'            => $request->phone,
    	'language'            => 'en-gb',
        'currencyCode' => 'EGP',

    ]);

    //you can add this method info foreach if you have multible items
    $fawryPay->addItem([
    	'productSKU'    => rand(1,3000000), //item id
    	'description'   => $product->des, //item name
    	'price'         =>  $product->price, //item price
    	'quantity'      => '1', //item quantity
    ]);
    // dd($fawryPay);
    //generatePayURL('your order unique id','your order discription','success url','failed url')
    
    $pay_url = $fawryPay->generatePayURL(rand(1,3000000),$product->name,'https://www.shiiry.com/Callback','https://www.shiiry.com/Callback');
    // dd($pay_url);
    return redirect($pay_url);

    }

    public function callback(){

        $ref_id = NULL;
        if(request('merchantRefNum')){ //fawry failed
            $ref_id = request('merchantRefNum');
        } elseif(request('MerchantRefNo')){ //fawry ipn
            $ref_id = request('MerchantRefNo');
        } elseif(request('chargeResponse')){ //fawry response is success
            $chargeResponse = json_decode(request('chargeResponse'));
            $ref_id = isset($chargeResponse->merchantRefNumber)?$chargeResponse->merchantRefNumber:NULL;
        }

        if(!$ref_id) return abort('404');

        $response = (new FawryPay)->checkStatus($ref_id);
        if (isset($response->paymentStatus) and $response->paymentStatus=='PAID') { //paid
            if((Session::get('order_id'))!= null){
                $order= Order::where('id', Session::get('order_id'))->first();
                // dd($order);
                $code= $order->code;
                $test = explode('P', $code);
                // dd(end($test));
                $child_code = Code::where('code',$code)->first();
                // $user = User::find($parent);
                $generation = (substr((substr($code, strpos($code, "%G") + 2)), 0,1)) + 1 ; // generation of auth user.
                // $first_parent_id = (substr($code, -1)); // that will increase balance 30 EGP .
                $first_parent_id = end($test); // that will increase balance 30 EGP .
                $parent = (User::find($first_parent_id));
                // dd($parent);
            }
            //   dd($user);
if($order != NULL){
    $order->is_paid = '1';
    $child_code->child_id = $order->user_id;
    // dd($generation);
// dd($generation - $parent->generation);
    if ( ($generation - $parent->generation ) == 6 ){
        $parent->balance += 30;
    }

    // $user->balance += 30;
    $order->save();
    $parent->save();
    $child_code->save();
    return view('successPage');
    dd('Paid Successfully',$response);
}else{
    return $response;
}

          
        } else {

            // for test only

         

            // end test


            // return view('successPage');
             return $response;
            dd($response);
        }
    }



   




}
