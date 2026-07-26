<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $member = GroupMember::where('group_id', $request->group_id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$member) {
            abort(403);
        }

        Message::create([
            'group_id' => $request->group_id,
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return back();
    }
}