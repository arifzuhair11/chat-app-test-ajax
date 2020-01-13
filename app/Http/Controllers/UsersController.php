<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      $html = '';
      $users = User::orderBy('name')->where('id', '!=', auth()->user()->id)->get();
      foreach ($users as $key => $value) {
        // dump($value->id);
        $html .= "<div class='chat_list' onclick='openChat(".$value->id.")'>".
              "<div class='chat_people' data-id='".$value->id."'>".
              "<div class='chat_img text-center'> ".User::generateInitials($value->name)."</div>".
              "<div class='chat_ib'>".
              "<h5>".$value->name." <span class='chat_date'></span></h5></div></div></div>";
      }
        return response()->json(['html'=>$html]);
    }
}
