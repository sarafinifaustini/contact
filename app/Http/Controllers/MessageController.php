<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
        $messages= Message::all();
        $users = Cat::all();
        // dd($messages);
        // return $messages;
        return view('dashboard.admin.bulkSms',compact('messages','users'));

    }
    public function send(Request $request){
        $message = Message::where('id',$request->message->id)->first();
        if($message){
            $cats= Cat::All();
            if($cats->count()>0){
                foreach($cats as $cat){
                    $users=User::All();
                    $cat_id= $cat->id;
                    foreach($users as $user){
                    $user_cat_id= $user->cat_id;
                    if($users->count()>0 && $cat_id==$user_cat_id){
                $composeMessage = str_replace('[USER]',$cat->category,$message->message);
                $args = http_build_query(array(
                'token' => '<token-provided>',
                'from'  => 'The Standard Group',
                'to'    => $user->phone,
                'text'  => $composeMessage));

            $url = "http://api.sparrowsms.com/v2/sms/";

            # Make the call using API.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // Response
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status_code == 200)
            {
                $response = json_decode($response);
                echo $response->response;
            }

                }
            }
        }
        }
    }
}
    }

