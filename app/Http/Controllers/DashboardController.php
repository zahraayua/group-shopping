<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\ShoppingList;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $groupIds = $user->groups->pluck('id');

    $totalGroups = $groupIds->count();

    $totalItems = ShoppingList::whereIn(
        'group_id',
        $groupIds
    )->count();

    $totalCost = ShoppingList::whereIn(
        'group_id',
        $groupIds
    )->sum('estimated_price');

    $checkedItems = ShoppingList::whereIn(
        'group_id',
        $groupIds
    )
    ->where('is_checked', true)
    ->count();

    $uncheckedItems = ShoppingList::whereIn(
        'group_id',
        $groupIds
    )
    ->where('is_checked', false)
    ->count();

    $progress = $totalItems > 0
        ? round(($checkedItems / $totalItems) * 100)
        : 0;

    $groups = $user->groups()
        ->with([
            'members',
            'shoppingLists'
        ])
        ->latest()
        ->take(4)
        ->get();

    return view(
        'dashboard',
        compact(
            'totalGroups',
            'totalItems',
            'totalCost',
            'checkedItems',
            'uncheckedItems',
            'progress',
            'groups'
        )
    );
}

    public function monitoring()
{
    $totalGroups = Group::count();

    $totalUsers = User::count();

    $totalItems = ShoppingList::count();

    $totalBill = Payment::sum('amount');

    $paidBill = Payment::where('status','paid')
                    ->sum('amount');

    $pendingBill = Payment::where('status','pending')
                    ->sum('amount');

    $payments = Payment::with('user')
                    ->latest()
                    ->take(5)
                    ->get();

    return view(
        'dashboard.monitoring',
        compact(
            'totalGroups',
            'totalUsers',
            'totalItems',
            'totalBill',
            'paidBill',
            'pendingBill',
            'payments'
        )
    );
}
}