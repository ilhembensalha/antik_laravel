<?php

namespace App\Http\Controllers\API;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
   

    public function getMessages($senderId, $receiverId)
    {
        $messages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->with(['sender', 'receiver'])->get();
    
        return response()->json($messages);
    }

/*public function sendMessage(Request $request)
{
    $message = new Message([
        'sender_id' => $request->input('sender_id'),
        'receiver_id' => $request->input('receiver_id'),
        'content' => $request->input('content'),
    ]);

    $message->save();
  //  broadcast(new NewMessage($messageContent))->toOthers();

    return response()->json(['message' => $message], 201);
}*/
public function sendMessage(Request $request)
{
    $message = new Message([
        'sender_id' => $request->input('sender_id'),
        'receiver_id' => $request->input('receiver_id'),
        'content' => $request->input('content'),
    ]);

    $message->save();

    //broadcast(new NewMessage($message));
    event(new NewMessage($message));

    return response()->json(['message' => $message], 201);
}

}
