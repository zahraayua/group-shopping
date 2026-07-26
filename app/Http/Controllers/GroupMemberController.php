<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function store(Request $request)
{
    // Cek apakah yang login adalah admin grup
    $isAdmin = GroupMember::where('group_id', $request->group_id)
        ->where('user_id', auth()->id())
        ->where('role', 'admin')
        ->exists();

    if (!$isAdmin) {
        abort(403);
    }

    // Cek apakah user sudah menjadi anggota
    $exists = GroupMember::where('group_id', $request->group_id)
        ->where('user_id', $request->user_id)
        ->exists();

    if (!$exists) {
        GroupMember::create([
    'group_id' => $request->group_id,
    'user_id' => $request->user_id,
    'role' => 'member',
]);
    }

    return back();
}
}