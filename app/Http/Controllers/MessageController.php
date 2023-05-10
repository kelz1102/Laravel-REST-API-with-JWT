<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($id)
    {
        $messageId = auth()->user()->id + $id;
            $userMessages = Message::where('message_id', $messageId)
                                ->orderByDesc('created_at')
                                ->get();
    
                    return response()->json([
                        'status' => 'success',
                        'messages' => $userMessages,
                     ]); 
    }
    public function store(Request $request, $id)
    {
            $messageId = auth()->user()->id + $id;
                Message::create([
                    'from_id' => auth()->user()->id,
                    'to_id' => $id,
                    'message_id' => $messageId,
                    'message' => $request->message,
                ]);
    }
    public function destroy($id){

                Message::where('from_id', $id)
                    ->orWhere('to_id', $id)
                    ->delete();
       }
}
