<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\UserConversation;
use DB;

class AdminUserConversationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Review';
        $users = UserConversation::select(DB::raw('distinct(sender_id), receiver_id'))->get();
        return view('admin.conversations.index', compact('pageTitle', 'users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getConversations($senderId, $receiverId)
    {
        $pageTitle = 'Admin - View';
        $conversations = UserConversation::where(['sender_id' => $senderId, 'receiver_id' => $receiverId])->orWhere(['sender_id' => $receiverId, 'receiver_id' => $senderId])->get();

        return view('admin.conversations.view', compact('pageTitle', 'conversations'));
    }

    public function getMessage($id)
    {
        $message = UserConversation::select('message')->where('id',$id)->first();
        return response()->json(['status' => 'success','response' => $message]);
    }
}
