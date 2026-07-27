@extends('layouts.main')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 rounded-lg p-4 mb-6">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-700 rounded-lg p-4 mb-6">
    {{ session('error') }}
</div>
@endif

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Belanja</h1>
    <p class="text-slate-500 mt-1">{{ $group->name }} - {{ $group->description }}</p>
</div>

{{-- ================= MENU FITUR GROUP ================= --}}

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

    <a href="{{ route('shopping-lists.create',['group'=>$group->id]) }}"
       class="bg-white rounded-xl shadow border border-slate-200 p-5 text-center hover:shadow-lg transition">

        <div class="text-3xl mb-2">🛒</div>

        <div class="font-semibold text-slate-700">
            Shopping List
        </div>

    </a>

    <a href="{{ route('receipts.create',['group'=>$group->id]) }}"
       class="bg-white rounded-xl shadow border border-slate-200 p-5 text-center hover:shadow-lg transition">

        <div class="text-3xl mb-2">🧾</div>

        <div class="font-semibold text-slate-700">
            Upload Nota
        </div>

    </a>

    <a href="{{ route('groups.split-bill',$group->id) }}"
       class="bg-white rounded-xl shadow border border-slate-200 p-5 text-center hover:shadow-lg transition">

        <div class="text-3xl mb-2">💰</div>

        <div class="font-semibold text-slate-700">
            Split Bill
        </div>

    </a>

    <a href="{{ route('payments.index',$group->id) }}"
       class="bg-white rounded-xl shadow border border-slate-200 p-5 text-center hover:shadow-lg transition">

        <div class="text-3xl mb-2">💳</div>

        <div class="font-semibold text-slate-700">
            Pembayaran
        </div>

    </a>

    <a href="{{ route('payments.history') }}"
       class="bg-white rounded-xl shadow border border-slate-200 p-5 text-center hover:shadow-lg transition">

        <div class="text-3xl mb-2">📜</div>

        <div class="font-semibold text-slate-700">
            Riwayat
        </div>

    </a>

</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    
    {{-- Kolom Kiri: Members & Add Members --}}
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col h-[280px]">
            <h2 class="text-lg font-bold text-slate-800 mb-3">Members</h2>
            <div class="flex-1 overflow-y-auto pr-1 space-y-2">
                @forelse($group->members as $member)
    <div class="py-2 px-3 bg-slate-50 border border-slate-100 rounded-lg text-slate-700 font-medium flex items-center justify-between">
        <span>{{ $member->name }}</span>

        @if($member->pivot->role == 'admin')
            <span class="text-[10px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded-md">
                Admin
            </span>
        @else
            <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-md">
                Member
            </span>
        @endif
    </div>
@empty
    <p class="text-slate-500 text-sm">Belum ada anggota.</p>
@endforelse
            </div>
        </div>

        @if($isAdmin)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
            <h2 class="text-lg font-bold text-slate-800 mb-3">Add Members</h2>
            <form action="{{ route('group-members.store') }}" method="POST">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                
                <div class="relative">
                    <select name="user_id" class="w-full border border-slate-200 rounded-lg p-2.5 bg-slate-50 text-slate-700 appearance-none focus:outline-none focus:ring-2 focus:ring-slate-400">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="mt-3 w-full bg-slate-800 text-white py-2.5 rounded-lg font-medium hover:bg-slate-700 transition">
                    Add Member
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Group Chat --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col h-[430px]">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Group Chat</h2>
            
            <div class="flex-1 overflow-y-auto pr-2 space-y-3 mb-4">
                @forelse($group->messages as $message)
                    @if($message->user_id == auth()->id())
                        <div class="flex flex-col items-end">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl rounded-tr-none p-3 max-w-[85%]">
                                <span class="block font-bold text-xs text-slate-700 mb-1">
                                    {{ $message->user->name }} 
                                    @if($group->members->where('id', $message->user_id)->first()?->pivot->role == 'admin')
    (Admin)
@endif
                                </span>
                                <p class="text-sm text-slate-600">{{ $message->message }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-start">
                            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none p-3 max-w-[85%]">
                                <span class="block font-bold text-xs text-slate-700 mb-1">
                                    {{ $message->user->name }}
                                    @if($group->members->where('id', $message->user_id)->first()?->pivot->role == 'admin')
    (Admin)
@endif
                                </span>
                                <p class="text-sm text-slate-600">{{ $message->message }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-slate-400 text-sm text-center py-10">Belum ada pesan.</p>
                @endforelse
            </div>

            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                <div class="flex gap-2">
                    <input type="text" name="message" placeholder="Tulis pesan..." class="flex-1 border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-slate-400" required>
                    <button class="bg-slate-800 text-white px-6 rounded-lg font-medium hover:bg-slate-700 transition">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Section: Struk Yang Diunggah (FIXED DI JALUR ACTION FORM HAPUS) --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-slate-800">Struk yang diunggah</h2>
        @if($isAdmin)
<a href="/receipts/create?group={{ $group->id }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-2 hover:bg-slate-600 transition">
    <span>↑</span> Unggah struk
</a>
@endif
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @isset($group->receipts)
            @forelse($group->receipts as $receipt)
                <div class="border border-slate-200 rounded-xl p-3 bg-white flex flex-col items-center justify-between text-center relative group">
                    
                    {{-- Tombol Hapus Struk di Pojok Kanan Atas Kartu (FIXED MANUAL URL) --}}
                    @if($isAdmin)
<div class="absolute top-2 right-2 z-10">
                        <form action="/receipts/{{ $receipt->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus struk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-1.5 rounded-lg transition shadow-sm border border-red-100" title="Hapus Struk">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v4M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- Link untuk melihat/klik gambar struk --}}
                    <a href="{{ asset('uploads/receipts/' . $receipt->image) }}" target="_blank" class="w-full block">
                        <div class="w-full h-24 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center overflow-hidden mb-2 hover:opacity-80 transition">
                            <img src="{{ asset('uploads/receipts/' . $receipt->image) }}" alt="Struk" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23cbd5e1\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\' ry=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><polyline points=\'21 15 16 10 5 21\'/></svg>';">
                        </div>
                        <span class="text-xs font-semibold text-slate-700 truncate block w-full hover:text-blue-600" title="{{ $receipt->image }}">
                            {{ $receipt->image }}
                        </span>
                    </a>

                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $receipt->created_at->diffForHumans() }}</span>
                    <span class="mt-2 text-[10px] bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full font-medium">Diproses</span>
                </div>
            @empty
                <div class="col-span-full border border-dashed border-slate-200 rounded-xl p-6 flex flex-col items-center justify-center text-slate-400">
                    <span class="text-sm">Belum ada struk yang diunggah.</span>
                </div>
            @endforelse
        @endisset
    </div>
</div>

{{-- Section: Daftar Belanja --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-slate-800">Daftar Belanja</h2>
       @if($isAdmin)
<a href="{{ route('shopping-lists.create', ['group'=>$group->id]) }}" class="bg-slate-800 text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-1 hover:bg-slate-600 transition">
    + Tambah Barang
</a>
@endif
    </div>

    <div class="space-y-3 mb-6">
        @forelse($group->shoppingLists as $item)

<div class="flex justify-between items-center bg-slate-50 border border-slate-200 rounded-xl p-4">


    {{-- KIRI --}}
    <div class="flex items-center gap-4">

        <div class="text-xl">
            @if($item->is_checked)
                🎉
            @else
                ⬜
            @endif
        </div>


        <div>

            <h3 class="font-bold text-slate-800
                {{ $item->is_checked ? 'line-through text-slate-400' : '' }}">
                {{ $item->item_name }}
            </h3>


            <p class="text-xs text-slate-500 mt-1">

                Qty:
                {{ $item->quantity }}

                •
                Rp {{ number_format($item->estimated_price) }}

            </p>



            <div class="mt-2 text-xs">

                Owner:

                @if($item->owner)

                    <span class="bg-slate-800 text-white px-3 py-1 rounded-full">
                        {{ $item->owner->name }}
                    </span>

                @else

                    <span class="text-slate-400">
                        Belum ada
                    </span>

                @endif


            </div>


        </div>


    </div>



    {{-- KANAN --}}
    <div class="flex flex-col gap-2">


        @if(!$item->owner)

        <form action="{{ route('shopping-lists.claim',$item->id) }}"
              method="POST">

            @csrf
            @method('PATCH')


            <button
            class="bg-indigo-800 text-white text-xs px-4 py-2 rounded-lg hover:bg-indigo-900">

                Klaim Barang

            </button>


        </form>

        @endif



        @if($isAdmin)

        <form action="{{ route('shopping-lists.check',$item->id) }}"
              method="POST">

            @csrf
            @method('PATCH')


            @if($item->is_checked)

            <button
            class="bg-red-600 text-white text-xs px-4 py-2 rounded-lg">

                Uncheck

            </button>


            @else

            <button
            class="bg-green-600 text-white text-xs px-4 py-2 rounded-lg">

                Check

            </button>


            @endif


        </form>

        @endif


    </div>



</div>


@empty
            <div class="text-center py-6 border border-dashed border-slate-200 rounded-xl text-slate-500 text-sm">
                <p class="font-medium">Belum ada barang</p>
                <p class="text-xs text-slate-400 mt-1">Tambahkan barang pertama ke daftar belanja.</p>
            </div>
        @endforelse
    </div>

    {{-- Footer Summary Statistik Belanja --}}
    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-100 text-center">
        <div>
            <p class="text-xs text-slate-400">Total Items</p>
            <h4 class="text-lg font-bold text-slate-700 mt-0.5">{{ $totalItems }}</h4>
        </div>
        <div>
            <p class="text-xs text-slate-400">Total Quantity</p>
            <h4 class="text-lg font-bold text-slate-700 mt-0.5">{{ $totalQuantity }}</h4>
        </div>
        <div>
            <p class="text-xs text-slate-400">Estimated Cost</p>
            <h4 class="text-lg font-bold text-slate-700 mt-0.5">Rp {{ number_format($totalCost) }}</h4>
        </div>
    </div>
</div>

<div class="flex justify-end">

<a href="{{ route('groups.split-bill', $group->id) }}"
   class="block text-center bg-slate-800 text-white font-semibold py-3 px-10 rounded-xl hover:bg-slate-700 transition">
    Rincian Pembagian
</a>

</div>

@endsection