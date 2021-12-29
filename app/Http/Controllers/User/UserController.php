<?php

namespace App\Http\Controllers\User;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\userResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    public function index(){
        $u =User::All();
        $users = userResource::collection($u); 
        return $users;
    }

   public function create(Request $request){
    //  dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'cat' => 'required',
            'password' => 'required|confirmed',
            // 'cpassword'=>'required|min:5|max:30|same:password',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email= $request->email;
        $user->cat_id= '1';
        $user->password = \Hash::make($request->password);
        $save = $user->save();
        // dd($save);
        if($save) {
            return redirect('admin/home')->with('Success','User Created Successflly');
        }else
        return redirect()->back()->with('Something Went Wrong','Failed to Register');

    }
     public function register(Request $request){
    //  dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'cat' => 'required',
            'password' => 'required|confirmed',
            // 'cpassword'=>'required|min:5|max:30|same:password',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email= $request->email;
        $user->cat_id= '1';
        $user->password = \Hash::make($request->password);
        $save = $user->save();
        // dd($save);
        if($save) {
            return redirect('admin/login')->with('Success','User Created Successflly');
        }else
        return redirect()->back()->with('Something Went Wrong','Failed to Register');

    }
    function check(Request $request){
        //Validate inputs
        $request->validate([
           'email'=>'required|email|exists:users,email',
           'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists on users table'
        ]);

        $creds = $request->only('email','password');
        if( Auth::guard('web')->attempt($creds) ){
            return redirect()->route('user.home');
        }else{
            return redirect()->route('user.login')->with('fail','Incorrect credentials');
        }
    }

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
    public function edit(User $user){
        $user = User::find($user->id);
        $cats = Cat::with('children')->whereNull('parent_id')->get();

   return view('dashboard.admin.edit',compact('user','cats'));
    }
    public function destroy($id){

        $com = User::find($id)->delete();
        // $deleted = User::where('id',$com)->delete();
        if($com){
          return redirect('admin/home');
        }
        return Response()->json($com);
        //  Session::flash('flash_message', 'Task successfully deleted!');
        //  $detail = User::where('id',$id->id)->delete();
        //  return Response()->json($detail);
        //  $id->delete();
        //   return redirect('admin/home');

   }
    public function update(Request $request,User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'cat_id' => 'required',
        ]);
        // $det = User::find($user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cat_id = '4';
        // $user->save();
        $user->update($request->all());
        $cats = Cat::with('children')->whereNull('parent_id')->get();

        $user->save();
       

        return redirect('admin\home');

    }
      public function show(Request $request){
        $u =User::All();
        // if(request()->ajax()){
        //     if($request->category(){
        //         $data=Cat
        //         )
        //     }
        // }
        $users = userResource::collection($u);
        $cats = Cat::with('children')->whereNull('parent_id')->get();
        //  return $users;
        return view('dashboard.admin.home',compact('users','cats'));
    }

    public function createUser()
{
      $cats = Cat::with('children')->whereNull('parent_id')->get();

      return view('dashboard.admin.addUser', compact('cats'));
}

public function editUser(User $user)
{
    //   if ($user->user_id != Auth::id()) {
    //     return redirect()->back();
    //   }

      $categories = Cat::with('children')->whereNull('parent_id')->get();

      return view('dashboard\admin\edit', compact('posts', 'cats'));
}
}

