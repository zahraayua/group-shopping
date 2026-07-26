@extends('layouts.main')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-8">
    <h1 class="text-3xl font-bold mb-6">
        Upload Receipt
    </h1>

    <form action="{{ route('receipts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="group_id" value="{{ $groupId ?? request('group') }}">

        <div class="mb-4">
            <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
        </div>

        <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-600 transition">
            Upload
        </button>
    </form>
</div>
@endsection