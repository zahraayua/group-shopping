<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use App\Models\Group;

class ShoppingListController extends Controller
{
    private function checkAdmin($groupId)
    {
        $isAdmin = Group::findOrFail($groupId)
            ->members()
            ->where('user_id', auth()->id())
            ->wherePivot('role', 'admin')
            ->exists();

        abort_unless($isAdmin, 403, 'Hanya admin yang dapat melakukan aksi ini.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $items = ShoppingList::all();

    return view(
        'shopping-lists.index',
        compact('items')
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $groupId = $request->group;

    $this->checkAdmin($groupId);

    return view(
        'shopping-lists.create',
        compact('groupId')
    );
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    ShoppingList::create([
        'group_id' => $request->group_id,
        'item_name' => $request->item_name,
        'quantity' => $request->quantity,
        'estimated_price' => $request->estimated_price,
        'is_checked' => false,
    ]);


    return redirect()
    ->route('groups.show', $request->group_id)
    ->with(
        'success',
        'Barang berhasil ditambahkan.'
    );
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    $item = ShoppingList::findOrFail($id);

    $this->checkAdmin($item->group_id);

    return view(
        'shopping-lists.edit',
        compact('item')
    );
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShoppingList $shoppingList)
{
    $this->checkAdmin($shoppingList->group_id);

    $shoppingList->update([
        'item_name' => $request->item_name,
        'quantity' => $request->quantity,
        'estimated_price' => $request->estimated_price,
    ]);

    return redirect()->route('shopping-lists.index');
}

public function check($id)
{
    $item = ShoppingList::findOrFail($id);

    $this->checkAdmin($item->group_id);

    $item->update([
        'is_checked' => !$item->is_checked
    ]);

    return back();
}

public function claim($id)
{
    $item = ShoppingList::findOrFail($id);


    // pastikan user anggota grup
    $isMember = $item->group
        ->members()
        ->where('users.id', auth()->id())
        ->exists();


    abort_unless(
        $isMember,
        403,
        'Anda bukan anggota grup.'
    );


    // jika sudah ada owner
    if ($item->owner_id) {

        return back()
            ->with(
                'error',
                'Barang sudah diklaim oleh user lain.'
            );

    }


    $item->update([
        'owner_id' => auth()->id()
    ]);


    return back()
        ->with(
            'success',
            'Barang berhasil diklaim.'
        );
}
/**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $shoppingList)
{
    $this->checkAdmin($shoppingList->group_id);

    $shoppingList->delete();

    return redirect()->back();
}
}