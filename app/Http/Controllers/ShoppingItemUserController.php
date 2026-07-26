<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\ShoppingList;
use App\Models\ShoppingItemUser;

class ShoppingItemUserController extends Controller
{
    public function edit(Group $group)
    {
        // Ambil seluruh anggota grup
        $members = $group->members;

        // Ambil seluruh barang belanja grup
        $shoppingLists = ShoppingList::where(
            'group_id',
            $group->id
        )->get();

        return view(
            'shopping-items.assign',
            compact(
                'group',
                'members',
                'shoppingLists'
            )
        );
    }

    public function update(Request $request, Group $group)
{
    // Hapus data assign sebelumnya
    ShoppingItemUser::whereIn(
        'shopping_list_id',
        $group->shoppingLists->pluck('id')
    )->delete();

    $owners = $request->owners ?? [];

    foreach ($owners as $shoppingListId => $users) {

        foreach ($users as $userId) {

            ShoppingItemUser::create([

                'shopping_list_id' => $shoppingListId,

                'user_id' => $userId

            ]);

        }

    }

    return redirect()
        ->route('groups.show', $group->id)
        ->with(
            'success',
            'Assign owner berhasil disimpan.'
        );
}
}