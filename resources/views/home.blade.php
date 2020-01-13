@extends('layouts.app')

@section('content')
<div class="container">
  <div class="messaging">
        <div class="inbox_msg">
          <div class="inbox_people">

            <div class="inbox_chat" id="userList">
            </div>
            <!-- inbox end -->
          </div>
          <!-- People list end  -->

          <div class="mesgs">
            <div class="mesg_header">

            </div>
            <div class="msg_history" id="messagesSpace">

            </div>
            <form id="chatSpace">
              {{ csrf_field() }}
              <input type="hidden" name="receiver_id" value="">
              <div class="type_msg">
                <div class="input_msg_write">
                  <input type="text" class="write_msg" placeholder="Type a message" name="message" />
                  <button class="msg_send_btn" id="sendBTN" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
</div>
<link rel="stylesheet" href="{{ asset('css/chatBox.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
 <script>
   $(document).ready(function(){
     getUserList();

     setInterval(function(){
        updateChat();
     },5000)
   });

   $('#sendBTN').on('click', function(){
     data = $('#chatSpace').serialize();
     $.post({
       url: '/messages',
       data : data,
       success : function(data)
       {
           updateChat();
          $('input[name="message"]').val('');
       }
     });
   });

  function openChat(to_user){
    loadMessage(to_user);
  }
   function getUserList()
   {
     $.get({
       url: '/usersIndex',
       success : function(response)
       {
         $('#userList').html(response['html']);
       }
     });
   }
   function updateChat(){
       to_user = $("input[name='receiver_id']").val();
       if(to_user != ''){
         loadMessage(to_user);
       }
   }
   function loadMessage(receiver_id)
   {
     $('input[name="receiver_id"]').val(receiver_id);
      $.get({
        url: '/messages',
        data : {receiver_id:receiver_id},
        success : function(res)
        {
          $('#messagesSpace').html(res['html']);
        }
      })
   }
 </script>
@endsection
