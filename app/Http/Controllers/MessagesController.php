<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\User;
use App\Messages;
use Illuminate\Http\Request;
use App\Http\Requests;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      $auth_id = auth()->user()->id;
      $html = '';
      $data = Messages::where('sender_id', auth()->user()->id)
                        ->where('receiver_id', $req->receiver_id)
                        ->orWhere('sender_id', $req->receiver_id)
                        ->where('receiver_id', auth()->user()->id)
                        ->get();
      foreach ($data as $key => $value) {
        if($value->receiver_id == $auth_id){
          $html .="<div class='incoming_msg'>".
                  "<div class='incoming_msg_img text-center'>".User::generateInitials($value->sender->name)."</div>".
                  "<div class='received_msg'>".
                  "<div class='received_withd_msg'>".
                  "<p>". $value->message ."</p>".
                  "<span class='time_date'> ".$value->created_at->format('D, d M Y H:i')." </span></div></div></div>";
        }else{
          $html .="<div class='outgoing_msg'>".
                  "<div class='sent_msg'>".
                  "<p>".$value->message."</p>".
                  "<span class='time_date'> ".$value->created_at->format('D, d M Y H:i')." </span> </div></div>" ;
        }
      }
        return response()->json(['html'=> $html]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $message = Messages::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
