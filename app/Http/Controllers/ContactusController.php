<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Controllers\Controller;


use Carbon\Carbon;
use Illuminate\Http\Request;


class ContactusController extends Controller
{
    //
    public function index(){

            $messages= Contact::paginate(10);
        return view('admin.message.index',compact('messages'));
    }

    public function destroy($id)
    {
        $message = Contact ::find($id);
        $message-> delete();
        session() -> flash('success', trans('deleted successfully'));
        return redirect() -> route('message.index');
    }
}
