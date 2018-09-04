<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\User;
use App\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    public function getContacts(){
        //get all users exept the one who is autentificated
        $user = User::all()->except(auth()->id());

        //map contacts with unread messeges
        $unreadIds = Messages::select(DB::raw("`from` as sender_id, count(`from`) as messages_count"))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $user = $user->map(function($contact) use ($unreadIds){
            $contactunread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactunread ? $contactunread->messages_count : 0;

            return $contact;
        });

        return response()->json($user);
    }

    public function getMessagesFor($id){
        Messages::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

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
