<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function index($id)
    {

        $user = User::findOrFail($id);
                    
        return response()->json([
            'status' => 'success',
            'chat' => $user,
        ]);
    }
    public function store(Request $request) 
    {
        $qwe = Chat::where('chat_id', $request->chat_id)
                    ->where('user_id', auth()->user()->id)
                    ->orWhere('user_id', $request->chat_id )
                    ->orWhere('chat_id', auth()->user()->id)->first();
        if($qwe){
            return response()->json([
                'status' => 'failed',
            ]);
        }else if(!$qwe){
              Chat::create([
            'user_id' => auth()->user()->id,
            'chat_id' => $request->chat_id,
        ]);
        }
      
    }
      public function hasChats()
    {

          $user1 = Chat::with('user1')->where('user_id', auth()->user()->id)->get();
          $user2 = Chat::with('user2')->where('chat_id', auth()->user()->id)->get();
            
            return response()->json([
                'status' => 'success',
                'sent_to' =>  $user1,
                'receive_from' => $user2

            ]);
    }
    public function destroy($id)
    {

        Chat::where('user_id', $id)
                    ->orWhere('chat_id', $id)
                    ->delete();
    }
    public function search(Request $request)
    {

        $q = $request->input('q');
        $users = User::where('name', 'LIKE', '%'.$q.'%')->get();

            return response()->json([
                'status' => 'success',
                'searched' => $users
            ]);
    } 
}
