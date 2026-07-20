<?php

namespace App\Http\Controllers;

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

    public function get_message($id)
    {
        $authId = Auth::id();
        $messages = Message::with('sender', 'receiver')->where(function ($q) use ($authId, $id) {
            $q->where('sender_id', $authId)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($authId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();
        $users = User::whereNot('id', auth()->id())->get();
        return Inertia::render('Message',[
            'users'=>$users,
            'messages' => $messages, 
            'selectedUser' => $id
            ]);
    }

    public function store_message(Request $request)
    {
        $valiMessage = $request->validate([
            'receiver_id' => 'required',
            'message' => 'required'
        ]);
        $valiMessage['sender_id'] = Auth::id();
        Message::create($valiMessage);
        return redirect()->back();
    }
}
