<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;

class GroupController extends Controller
{
    public function index()
{
    $groups = auth()->user()->groups()
        ->with(['members','shoppingLists'])
        ->get();

    $totalGroups = $groups->count();
    $totalItems = $groups->sum(function ($group) {
        return $group->shoppingLists->count();
    });
    $totalMembers = $groups->sum(function ($group) {
        return $group->members->count();
    });

    return view(
        'groups.index',
        compact(
            'groups',
            'totalGroups',
            'totalItems',
            'totalMembers'
        )
    );
}


    public function create()
    {
        return view('groups.create');
    }

public function store(Request $request)
{
    $group = Group::create([
        'name' => $request->name,
        'description' => $request->description,
        'created_by' => auth()->id(),
    ]);

    GroupMember::create([
        'group_id' => $group->id,
        'user_id' => auth()->id(),
        'role' => 'admin',
    ]);

    return redirect()->route('groups.index');
}

    public function show(string $id)
    {
        $member = GroupMember::where('group_id', $id)
    ->where('user_id', auth()->id())
    ->exists();

if (!$member) {
    abort(403);
}
$isAdmin = GroupMember::where('group_id', $id)
    ->where('user_id', auth()->id())
    ->where('role', 'admin')
    ->exists();
        // Menambahkan 'receipts' ke dalam eager loading
        $group = Group::with([
            'messages.user',
            'members',
            'receipts',
            'shoppingLists' 
        ])->findOrFail($id);

        $users = User::all();

        $totalItems = $group->shoppingLists->count();
        $totalQuantity = $group->shoppingLists->sum('quantity');
        
        // PERBAIKAN: Mengubah 'estimated_price' menjadi 'price' agar cocok dengan output OCR
        $totalCost = $group->shoppingLists->sum(function($item) {
    return $item->estimated_price * $item->quantity;
});

        return view(
    'groups.show',
    compact(
        'group',
        'users',
        'totalItems',
        'totalQuantity',
        'totalCost',
        'isAdmin'
    
            )
        );
    }

    public function edit(string $id)
{
    $isAdmin = GroupMember::where('group_id', $id)
        ->where('user_id', auth()->id())
        ->where('role', 'admin')
        ->exists();

    if (!$isAdmin) {
        abort(403);
    }

    $group = Group::findOrFail($id);

    return view('groups.edit', compact('group'));
}
    public function update(Request $request, string $id)
{
    $isAdmin = GroupMember::where('group_id', $id)
        ->where('user_id', auth()->id())
        ->where('role', 'admin')
        ->exists();

    if (!$isAdmin) {
        abort(403);
    }

    $group = Group::findOrFail($id);

    $group->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('groups.index');
}

    public function destroy(string $id)
{
    $isAdmin = GroupMember::where('group_id', $id)
        ->where('user_id', auth()->id())
        ->where('role', 'admin')
        ->exists();

    if (!$isAdmin) {
        abort(403);
    }

    $group = Group::findOrFail($id);

    $group->delete();

    return redirect()->route('groups.index');
}

public function splitBill($id)
{
    // Pastikan user adalah anggota grup
    $member = GroupMember::where('group_id', $id)
        ->where('user_id', auth()->id())
        ->exists();

    if (!$member) {
        abort(403);
    }

    // Ambil grup beserta relasinya
    $group = Group::with([
        'shoppingLists.owner',
        'members'
    ])->findOrFail($id);

    $summary = [];

    foreach ($group->members as $member) {

        $items = [];
        $total = 0;

        foreach ($group->shoppingLists as $item) {

    if ($item->owner_id == $member->id) {

        $subtotal = $item->estimated_price * $item->quantity;

        $items[] = [
            'nama'      => $item->item_name,
            'qty'       => $item->quantity,
            'harga'     => $item->estimated_price,
            'subtotal'  => $subtotal,
        ];

        $total += $subtotal;
    }
}

        $summary[] = [
            'user'  => $member,
            'items' => $items,
            'total' => $total,
        ];
    }

    return view(
        'groups.split_bill',
        compact(
            'group',
            'summary'
        )
    );
}  

}