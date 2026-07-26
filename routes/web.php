<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ShoppingItemUserController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    // Profile
    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

    Route::patch(
    '/shopping-lists/{id}/claim',
    [ShoppingListController::class,'claim']
)->name('shopping-lists.claim');

    // Groups
    Route::resource(
        'groups',
        GroupController::class
    );

    // Shopping Lists
    Route::resource(
        'shopping-lists',
        ShoppingListController::class
    );

    Route::patch(
        '/shopping-lists/{id}/check',
        [ShoppingListController::class, 'check']
    )->name('shopping-lists.check');

    Route::patch(
    '/shopping-lists/{id}/claim',
    [ShoppingListController::class, 'claim']
)->name('shopping-lists.claim');

    // Messages
    Route::post(
        '/messages',
        [MessageController::class, 'store']
    )->name('messages.store');

    // Group Members
    Route::post(
        '/group-members',
        [GroupMemberController::class, 'store']
    )->name('group-members.store');

 
        // Receipts
    Route::get(
        '/receipts/create',
        [ReceiptController::class, 'create']
    )->name('receipts.create');

    Route::post(
        '/receipts',
        [ReceiptController::class, 'store']
    )->name('receipts.store');

    // Rute untuk melihat detail struk
    Route::get(
        '/receipts/{id}',
        [ReceiptController::class, 'show']
    )->name('receipts.show');

    // Rute untuk menghapus struk
    Route::delete(
        '/receipts/{id}',
        [ReceiptController::class, 'destroy']
    )->name('receipts.destroy');

        // Assign Owner (Split Bill)
    Route::get(
        '/groups/{group}/assign-items',
        [ShoppingItemUserController::class, 'edit']
    )->name('shopping-items.assign');

    Route::post(
        '/groups/{group}/assign-items',
        [ShoppingItemUserController::class, 'update']
    )->name('shopping-items.update');

    // Split Bill
    Route::get(
        '/groups/{group}/split-bill',
        [GroupController::class, 'splitBill']
    )->name('groups.split-bill');

    // Bill Generation
    Route::post(
        '/groups/{group}/generate-bills',
        [BillController::class, 'generate']
    )->name('bills.generate');

    // Payments
    Route::get(
    '/groups/{group}/payments',
    [PaymentController::class, 'index']
    )->name('payments.index');

    Route::patch(
    '/payments/{payment}/pay',
    [PaymentController::class, 'pay']
    )->name('payments.pay');

    // Riwayat Transaksi
    Route::get(
    '/payments/history',
    [PaymentController::class, 'history']
    )->name('payments.history');

    Route::get(
    '/dashboard-monitoring',
    [DashboardController::class, 'monitoring']
)->name('dashboard.monitoring');

    // Aktifkan nanti jika SplitBillController sudah selesai dibuat
    /*
    Route::post(
        '/groups/{group}/split-bill',
        [SplitBillController::class, 'calculateAndStore']
    )->name('splitbill.store');
    */
});