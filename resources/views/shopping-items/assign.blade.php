@extends('layouts.main')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

    <h1 class="text-2xl font-bold text-slate-800 mb-2">
        Assign Owner Barang
    </h1>

    <p class="text-slate-500 mb-6">
        Group :
        <strong>{{ $group->name }}</strong>
    </p>

    <form method="POST"
          action="{{ route('shopping-items.update',$group->id) }}">

        @csrf

        <div class="overflow-x-auto">

            <table class="w-full border border-slate-200">

                <thead class="bg-slate-800 text-white">

                    <tr>

                        <th class="p-3 text-left">
                            Barang
                        </th>

                        <th class="p-3">
                            Qty
                        </th>

                        <th class="p-3">
                            Harga
                        </th>

                        @foreach($members as $member)

                            <th class="p-3">

                                {{ $member->name }}

                            </th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                @foreach($shoppingLists as $item)

                    <tr class="border-t">

                        <td class="p-3">

                            {{ $item->item_name }}

                        </td>

                        <td class="text-center">

                            {{ $item->quantity }}

                        </td>

                        <td class="text-center">

                            Rp {{ number_format($item->estimated_price) }}

                        </td>

                        @foreach($members as $member)

                        <td class="text-center">

                            <input
                                type="checkbox"

                                name="owners[{{ $item->id }}][]"

                                value="{{ $member->id }}"

                                class="w-5 h-5 rounded">

                        </td>

                        @endforeach

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-6">

            <button
                class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-lg font-semibold">

                Simpan Assign Owner

            </button>

        </div>

    </form>

</div>

@endsection