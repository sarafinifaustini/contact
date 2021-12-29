<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Contacts;
use Illuminate\Http\Request;
use App\Http\Resources\userResource;

class ContactController extends Controller
{
    public function index(){
        $u =Contacts::All();
        $contacts = userResource::collection($u);
        // dd($contacts);
          return $contacts;
        // return view('dashboard.admin.cats.contacts',compact('contacts','cats'));
    }
    public function show(Request $request){
        $u =Contacts::All();
        $contacts = userResource::collection($u);
        $cats = Cat::with('children')->whereNull('parent_id')->get();
        //  return $users;
        return view('dashboard.admin.cats.contacts',compact('contacts','cats'));
    }
}
