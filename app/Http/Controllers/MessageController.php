<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function message()
    {
        $users = User::whereNot('id', auth()->id())->get();
        return Inertia::render('Message', ['users' => $users]);
    }

    public function get_message($uuid)
    {
        $authId = Auth::id();
        $search =User::where('uuid',$uuid)->firstOrFail();
        $searchId=$search->id;
        $messages = Message::with('sender', 'receiver')->where(function ($q) use ($authId, $searchId) {
            $q->where('sender_id', $authId)->where('receiver_id', $searchId);
        })->orWhere(function ($q) use ($authId, $searchId) {
            $q->where('sender_id', $searchId)->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        $users = User::whereNot('id', auth()->id())->get();
        return Inertia::render('Message',[
            'users'=>$users,
            'messages' => $messages, 
            'selectedUser' => $search->uuid
            ]);
    }

    public function store_message(Request $request)
    {
        $valiMessage = $request->validate([
            'receiver_id' => 'required',
            'message' => 'required'
        ]);
        $valiMessage['sender_id'] = Auth::id();
        $message = Message::create($valiMessage);
        broadcast(new MessageSent($message))->toOthers();
        return redirect()->back();
    }
}
