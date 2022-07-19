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
use Hash;

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



//    new fawry

public function newFawry(){
                // https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init


                $merchantCode = 'siYxylRjSPy1YRVe3ouM6Q==';
            // $merchantRefNum  = rand(1,3000000);
            // dd($merchantRefNum);
            $merchantRefNum  = "unique-100";
            // $merchant_cust_prof_id  = rand(1,300);
            $merchant_cust_prof_id  = "123";
            $amount = '220.55';
            $returnUrl = "http://localhost:8000";
            $cardNumber = '4242424242424242';
            $cardExpiryYear = '25';
            $cardExpiryMonth = '05';
            $cvv = "123";
            $payment_method = 'CARD';
            $merchant_sec_key =  '72f6f149-6cb5-425d-8afe-5e34b5534ce7'; // For the sake of demonstration
            // $signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method .
            //                     $amount . $merchant_sec_key);
            $signature = hash('sha256' ,$merchantCode.$merchantRefNum.$merchant_cust_prof_id.$payment_method.$amount.$cardNumber.$cardExpiryYear.$cardExpiryMonth.$cvv.$returnUrl.$merchant_sec_key);
                //   dd($signature);
            $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
            $response = $httpClient->request('POST', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge', [
                'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept'       => 'application/json'
                        ],
                        'body' => json_encode([
                            "merchantCode"=> "siYxylRjSPy1YRVe3ouM6Q==",

                            "merchantRefNum"=> $merchantRefNum,

                            "customerName"=> "name",

                            "customerMobile"=> "01000000000",

                            "customerEmail"=> "email@gmail.com",

                            "customerProfileId"=> "123",

                            "cardNumber"=> "4242424242424242",

                            "cardExpiryYear"=> "25",

                            "cardExpiryMonth"=> "05",

                            "cvv"=> "123",

                            "amount"=> 220.55,

                            "currencyCode"=> "EGP",

                            "language" => "en-gb",

                            "chargeItems"=> [

                                [

                                "itemId"=> "1",

                                "description"=> "des1",

                                "price"=> 220.55,

                                "quantity"=> "1"

                                ]

                            ],

                            "enable3DS" => true,

                            "authCaptureModePayment" => false,

                            "returnUrl" => "http://localhost:8000",

                            "signature"=> $signature,

                            "paymentMethod"=> "CARD",

                            "description"=> "description"
                        ])
                    ]);
                    $response = json_decode($response->getBody()->getContents(), true);
                    $paymentStatus = $response['type']; // get response values

            return $response;

}

public function newFawry1(){
                $merchantCode = 'siYxylRjSPy1YRVe3ouM6Q==';
                $merchantRefNum  = "unique-28";
                // $merchantRefNum  = rand(1,3000000);
                $merchant_cust_prof_id  = "123";
                $return_url = 'http://localhost:8000';
            $item_id ='50506';
            $qty='1';
            $price='580.55';
            $merchant_sec_key =  '72f6f149-6cb5-425d-8afe-5e34b5534ce7'; // For the sake of demonstration
                $signature = hash('sha256' ,$merchantCode.$merchantRefNum.$merchant_cust_prof_id.$return_url.$item_id.$qty.$price.$merchant_sec_key);
            //   dd($signature);
            $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
            $response = $httpClient->request('POST', 'https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init', [
                'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'body' => json_encode(   [
                            "merchantCode" => $merchantCode,
                            "merchantRefNum" => $merchantRefNum,
                            "customerMobile"=> "01011941903",
                            "customerEmail" => "example@gmail.com",
                            "customerName" => "Ahmed Ali",
                            "customerProfileId"=> $merchant_cust_prof_id,
                            "paymentExpiry" => 1631138400000,
                            "chargeItems" => [
                                [
                                                "itemId" => $item_id,
                                                "description" => "Item Description",
                                                "price" => $price,
                                                "quantity" => "1"
                                ]
                                            ],
                                            "returnUrl"=> "http://localhost:8000",
                                            "authCaptureModePayment"=> false,
                                            "signature"=> $signature,
                        ] , true)
                    ]);
            //         $response = json_decode($response);
            //dd($response);
}


function newfawry2() {
                    // dd('here');
                    $merchantCode = 'siYxylRjSPy1YRVe3ouM6Q==';
                    // $merchantRefNum  = "unique-150";
                    $merchantRefNum  = "88";
                    $merchant_cust_prof_id  = "123";
                    $return_url = 'http://localhost:8000';
                $item_id ='50506';
                $qty='1';
                $price='580.55';
                $merchant_sec_key =  '72f6f149-6cb5-425d-8afe-5e34b5534ce7'; // For the sake of demonstration
                    $signature = hash('sha256' ,$merchantCode.$merchantRefNum.$merchant_cust_prof_id.$return_url.$item_id.$qty.$price.$merchant_sec_key);

                    $headers =  [
                        'Content-Type' => 'application/json',
                    ];
                $data = json_encode(   [

                        "merchantCode" => $merchantCode,
                        "merchantRefNum" => $merchantRefNum,
                        "customerMobile"=> "01011941903",
                        "customerEmail" => "example@gmail.com",
                        "customerName" => "Ahmed Ali",
                        "customerProfileId"=> $merchant_cust_prof_id,
                        "paymentExpiry" => 1631138400000,
                        "chargeItems" => [
                            [
                                            "itemId" => $item_id,
                                            "description" => "Item Description",
                                            "price" => $price,
                                            "quantity" => "1"
                            ]
                                        ],
                                        "returnUrl"=> "http://localhost:8000",
                                        "authCaptureModePayment"=> false,
                                        "signature"=> $signature,
                    ] , true) ;
                    dd($data);
                    $dataString =json_decode($data);
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, "https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init");
                    // // SSL important
                    // curl_setopt($ch, CURLOPT_POST, true);

                    //                         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    //                         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    //                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    //                         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                    //                         $response = curl_exec($ch);
                    // return $response;




                    $ch = curl_init();
                    // https://gateway.mastercard.com/api/nvp/version/59 //live
                    // https://test-gateway.mastercard.com/api/nvp/version/59 //test
                    curl_setopt($ch, CURLOPT_URL,"https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                    // AUTHORIZE
                    $headers = array();
                    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if(curl_errno($ch)) {
                    echo 'ERROR:'. curl_error($ch);
                    }

                    curl_close($ch);

                    print_r($result);
                    die();










                    // $output = curl_exec($ch);
                    // curl_close($ch);


                //    return $this - > response['response'] = json_decode($output);
}





public function newfawry3(Request $request){
    // dd($request->all());
    $request['code'] = Auth::user()->code;
    $request -> validate([
        'name' => 'required|string|max:100',
        'phone' => 'string',
        'address' => 'string|required',
        //  'code' => 'unique:orders',
    ]);

    // dd(Order::where([['code', '=', $request['code']],['is_paid', '1']])->count() > 0);
    if (Order::where([['code', '=', $request['code']],['is_paid', '1']])->count() > 0) {
          session() -> flash('Error', trans('Code already used'));
         return redirect() -> back();
     }



    // if($request['code'] != Auth::user()->code ){
    //     session() -> flash('Error', trans('Code Not Matched with your code'));
    // return redirect() -> back();
    // }
     // $merchantRefNum  =(string)$order[0];
    // Session::put('merchantRefNum', $merchantRefNum);
    $merchantRefNum  = rand(1,3000000);
    $request['merchantRefNumber'] = $merchantRefNum;
    // dd($request->all());
    $order =  app('App\Http\Controllers\OrdersController')->store($request->all());
    // $codes= app('App\Http\Controllers\OrdersController')->codeGenerator();
    // Session::put('order_id', $order);
    //   dd($order[0]);
    $product = Product::findOrFail($request->product_id);

    // $merchantCode = 'siYxylRjSPy1YRVe3ouM6Q==';
    $merchantCode = env('MERCHANT_CODE');
   
   
    // dd($merchantRefNum);
    $merchant_cust_prof_id  = Auth::user()->code;
     $return_url = 'https://shiiry.com/Status';
    //  $return_url = 'https://shiiry.com/';
$item_id = $request->product_id;
// dd($item_id);
$qty='1';
$price=$product->price;
$price= number_format((float)$price, 2, '.', '');
// $merchant_sec_key =  '72f6f149-6cb5-425d-8afe-5e34b5534ce7'; // For the sake of demonstration
$merchant_sec_key =  env('MERCHANT_SEC_KEY');
$signature = hash('sha256' ,$merchantCode.$merchantRefNum.$merchant_cust_prof_id.$return_url.$item_id.$qty.$price.$merchant_sec_key);

    $data=[
        'merchantCode'=>$merchantCode,
    'merchantRefNum'=> $merchantRefNum,
    'merchant_cust_prof_id'=> $merchant_cust_prof_id,
    'return_url'=> $return_url,
    'item_id'=> $item_id,
    'qty'=> $qty,
    'price'=>  $price,

    'signature'=> $signature,

    'name'=>$request->name,
    'email'=>$request->email,
    'phone'=>$request->phone,
];
    // dd($data);
return view('fawry',compact('data'));
}

public function newfawry3Callback(Request $request){

    //    dd($request->merchantRefNumber);
    if($request->orderStatus == 'PAID'){
        $codes= app('App\Http\Controllers\OrdersController')->codeGenerator();
        // $order= Order::where('id', Session::get('order_id'))->first();
        $order= Order::where('id', $request->merchantRefNumber)->first();
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


                $order->is_paid = '1';
                $order->total += $request->fawryFees;
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

                // end test


                return view('successPage');
    }else{
      Order::where('is_paid','0')->delete();
      return view('error')->with('error',$request->statusDescription);
    // return $request->statusDescription;

    }




}



//get callback

public function testcallback(){
    // dd(Session::get('merchantRefNum'));
            $merchantCode    = env('MERCHANT_CODE');
            $merchantRefNumber  = Session::get('merchantRefNum');
            $merchant_sec_key =  env('MERCHANT_SEC_KEY'); // For the sake of demonstration
            $signature = hash('sha256' ,$merchantCode.$merchantRefNumber.$merchant_sec_key);
            //   dd($signature);
            $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
            $response = $httpClient->request('GET', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status/v2', [

                'query' =>[
                    'merchantCode' =>$merchantCode,
                    'merchantRefNumber' =>$merchantRefNumber ,
                    'signature' => $signature
                    // 'signature' => '636887c8674053055209063aae860f03a3f8a8c8714eca558c8a3e34da1ccb80'
                ]
            ]);
            $response = json_decode($response->getBody()->getContents(), true);
            //   dd($response);
                $paymentStatus = $response['orderStatus']; // get response values
            if($paymentStatus == 'PAID'){
                $codes= app('App\Http\Controllers\OrdersController')->codeGenerator();
                $order= Order::where('id', $merchantRefNumber)->first();
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


                        $order->is_paid = '1';
                        $order->total += $response['fawryFees'];
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

                        // end test


                        return view('successPage');
            }else{
                Order::where('id',$merchantRefNumber)->delete();
                return view('error')->with('error',$response['failureReason']);
            }

}


// post call back

public function testCall(Request $request){

    //  dd($request->all());
    // return 'success';
    if($request['orderStatus'] == 'PAID' ){
    // if($request['statusCode'] == 200 ){
        
        // $order= Order::where('id', $request['merchantRefNumber'])->first();
        $order= Order::where('merchantRefNumber', $request['merchantRefNumber'])->first();
        //  dd($order);
        $codes= app('App\Http\Controllers\OrdersController')->codeGenerator($order->user_id);
                // dd($order);
                $code= $order->code;
                $test = explode('P', $code);
                // dd(end($test));
                $child_code = Code::where('code',$code)->first();
                // dd($child_code);
                // $user = User::find($parent);
                $generation = (substr((substr($code, strpos($code, "%G") + 2)), 0,1)) + 1 ; // generation of auth user.
                // $first_parent_id = (substr($code, -1)); // that will increase balance 30 EGP .
               
                $first_parent_id = end($test); // that will increase balance 30 EGP .
                // dd($first_parent_id);
                $parent = (User::find($first_parent_id));



                $order->is_paid = '1';
                $order->total += $request['fawryFees'];
                $child_code->child_id = $order->user_id;
                // dd($generation);
    // dd($generation - $parent->generation);
    if($parent){
    
    
                if ( ($generation - $parent->generation ) == 6 ){
                    $parent->balance += 30;
                }
                $parent->save();
            }
                // $user->balance += 30;
                $order->save();
               
                $child_code->save();

                // end test


                return view('successPage');
    }else{
        // Order::where('merchantRefNumber',$request['merchantRefNumber'])->delete();
        return view('error')->with('error',$request['failureReason']);
    }


}



public function return_url(Request $request){
    //  dd($request);
    // if($request->orderStatus == 'PAID'){
    if($request->statusCode == 200){
                return view('successPage');
    }else{
        // Order::where('is_paid','0')->delete();
      return view('error')->with('error',$request->statusDescription);

}
}


}


// true

    //   'merchantCode' =>  'siYxylRjSPy1YRVe3ouM6Q==',
    //   'merchantRefNum' => "123",
    //   'customerName' => 'Ahmed Ali',
    //   'customerMobile' => '01234567891',
    //   'customerEmail' => 'example@gmail.com',
    //   "cardNumber"=> "5543474002259998",

    //   "cardExpiryYear"=> "25",

    //   "cardExpiryMonth"=> "05",

    //   "cvv"=> "123",
    //   'customerProfileId'=> "456",
    //   'amount' => '580.55',

    //   'currencyCode' => 'EGP',
    //   'language' => 'en-gb',
    //   'chargeItems' => [
    //                       //   'itemId' => rand(1,3000000),
    //                         'itemId' => "789",
    //                         'description' => 'Item Description',
    //                         'price' => '580.55',
    //                         'quantity' => '1'
    //                     ],
    //   'signature' => $signature,
    //   'paymentMethod' => 'CARD',
    //   'enable3DS' => true,
    //   'returnUrl'=> 'http://localhost:8000',
    //   "authCaptureModePayment" => false,

    //   'description' => 'example description'


    // http://localhost:8000/?type=ChargeResponse&referenceNumber=9100207727&merchantRefNumber=unique-14&orderAmount=220.55&paymentAmount=221.55&fawryFees=1&orderStatus=PAID&paymentMethod=PayUsingCC&paymentTime=1649762705333&customerName=name&customerMobile=01000000000&customerMail=email%40gmail.com&customerProfileId=123&authNumber=661775&signature=dfdd0d3043245414705332403790af4cd1fca30352b21ed66616cb752ac25cdd&taxes=0&statusCode=200&statusDescription=Operation%20done%20successfully&basketPayment=false

// init

// 'merchantCode' => $merchantCode,
// 'merchantRefNum' => $merchantRefNum,
// 'customerMobile'=> '01011941903',
// 'customerEmail' => 'example@gmail.com',
// 'customerName' => 'Ahmed Ali',
// 'customerProfileId'=> $merchant_cust_prof_id,
// 'paymentExpiry' => 1631138400000,
// 'chargeItems' => [
//                     'itemId' => $item_id,
//                     'description' => 'Item Description',
//                     'price' => $price,
//                     'quantity' => '1'
//                 ],
//                 'returnUrl'=> 'http://localhost:8000',
//                 'authCaptureModePayment'=> false,
//                 'signature'=> $signature,



// http://localhost:8000/?type=ChargeResponse&referenceNumber=9100358772&merchantRefNumber=unique-20&orderAmount=580.55&paymentAmount=581.55&fawryFees=1&orderStatus=PAID&paymentMethod=PayUsingCC&paymentTime=1649767382082&customerName=Ahmed%20Ali&customerMobile=01011941903&customerMail=example%40gmail.com&customerProfileId=123&authNumber=661775&signature=06ca6596f43493c149826464a21733e8316f86c594b45f074cf6e3afea4f94d5&taxes=0&statusCode=200&statusDescription=Operation%20done%20successfully&basketPayment=false

// https://shiiry.com/?type=ChargeResponse&referenceNumber=9100361683&merchantRefNumber=112&orderAmount=100&paymentAmount=101&fawryFees=1&orderStatus=PAID&paymentMethod=PayUsingCC&paymentTime=1650285121403&customerName=Ahmed%20Ali&customerMobile=01011941903&customerMail=example%40gmail.com&customerProfileId=gN7TWiM0%25G6%26%2320%23P19%23P18%23P17%23P16%23P8&signature=9cd6f0babad31bd262917abd0bb5aa551fbed7c96a3c1f5eee83f2f3f3420d56&taxes=0&statusCode=200&statusDescription=Operation%20done%20successfully&basketPayment=false