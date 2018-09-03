<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\User;
use App\Messages;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function getContacts(){
        $user = User::all()->except(auth()->id());
        return response()->json($user);
    }

    public function getNumberUnreadMessages(){
        $user = User::count()
    }

    public function getMessagesFor($id){
        $messages =
            Messages::where(
                function($q) use ($id){
                    $q->where('from', auth()->id());
                    $q->where('to', $id);
                })
                ->orWhere(
                    function($q) use ($id){
                        $q->where('from', $id);
                        $q->where('to', auth()->id());
                    })
                ->get();

        return response()->json($messages);
    }

    public function send(Request $request){
        $message = Messages::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text'=> $request->text
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }
}
