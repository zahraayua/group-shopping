<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(Group $group)
{
    $payments = Payment::with('user')
        ->where('group_id', $group->id)
        ->get();

    $totalBill = $payments->sum('amount');

    $paidBill = $payments
        ->where('status','paid')
        ->sum('amount');

    $pendingBill = $payments
        ->where('status','pending')
        ->sum('amount');

    $paidCount = $payments
        ->where('status','paid')
        ->count();

    $pendingCount = $payments
        ->where('status','pending')
        ->count();

    return view(
        'payments.index',
        compact(
            'group',
            'payments',
            'totalBill',
            'paidBill',
            'pendingBill',
            'paidCount',
            'pendingCount'
        )
    );
}

    public function pay($id)
{
    $payment = Payment::with('group')
        ->findOrFail($id);


    $isAdmin = $payment->group
        ->members()
        ->where('users.id', auth()->id())
        ->wherePivot('role', 'admin')
        ->exists();


    if (!$isAdmin) {
        abort(403, 'Anda tidak memiliki akses.');
    }


    $payment->update([
        'status' => 'paid'
    ]);


    return redirect()
        ->back()
        ->with(
            'success',
            'Pembayaran berhasil dikonfirmasi.'
        );
}

public function history()
{
    $user = auth()->user();

    $payments = Payment::with(['user', 'group'])
        ->whereHas('group.members', function($query) use ($user){
            $query->where('users.id', $user->id);
        })
        ->latest()
        ->get();


    return view(
        'payments.history',
        compact('payments')
    );
}

}