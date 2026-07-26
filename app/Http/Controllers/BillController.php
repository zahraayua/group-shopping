<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function generate(Group $group)
    {
        // Hapus tagihan lama agar tidak dobel
        Payment::where('group_id', $group->id)->delete();

        // Load relasi yang diperlukan
        $group->load([
            'shoppingLists.owner',
            'members'
        ]);

        foreach ($group->members as $member) {

            $total = 0;

            foreach ($group->shoppingLists as $item) {

                if ($item->owner_id == $member->id) {

                    $total +=
                        $item->estimated_price *
                        $item->quantity;
                }
            }

            Payment::create([

                'group_id' => $group->id,

                'user_id'  => $member->id,

                'amount'   => $total,

                'status'   => 'pending'

            ]);
        }

       return redirect()
    ->route('payments.index', $group->id)
    ->with(
        'success',
        'Tagihan berhasil dibuat.'
    );
    }
}