<?php

namespace App\Http\Controllers;

use App\Product;
use App\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $section_1 = Product ::inRandomOrder()->limit(3)->get();
        $section_2 = Product ::orderBy('id','desc')->inRandomOrder()->limit(50)->get();
        $section_3 = Product ::inRandomOrder()->limit(50)->get();
        // dd($section_3);
        // return view('home');
        return view('site.index',compact('section_1','section_2','section_3'));
    }
    public function shop(){
        $products = Product::orderBy('id','desc')->paginate(20);
        return view('site.shop',compact('products'));
    }
    public function details($id){
        $product = Product::findOrFail($id);
        $related = Product::where('id','!=',$id)->inRandomOrder()->limit(8)->get();
        return view('site.product-details',compact('product','related'));
    }
    public function search(Request $request){
        $products = Product::where('name','like','%'.$request->param .'%')->orderBy('id','desc')->paginate(20);
        return view('site.shop',compact('products'));
    }
    public function about(){
        return view('site.about');
    }
    public function contact(){
        return view('site.contact');
    }
    public function set_contactus(Request $request){
        $data = $request -> validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string',
            'message' => 'required',

        ]);
        $data = $request->all();
        Contact::create($data);
        session() -> flash('success', trans('Sent Successfully'));
        return redirect()->back();
    }
}
