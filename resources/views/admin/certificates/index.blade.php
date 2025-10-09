@extends('layouts.admin')

@section('title', 'Certificates Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">
    <h1 class="text-2xl font-semibold mb-6">📜 Certificate Management</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded text-center">
            <div class="text-lg font-semibold text-blue-800">{{ $stats['total'] }}</div>
            <div class="text-sm text-blue-600">Total Certificates</div>
        </div>
        <div class="bg-green-100 p-4 rounded text-center">
            <div class="text-lg font-semibold text-green-800">{{ $stats['issued'] }}</div>
            <div class="text-sm text-green-600">Issued</div>
        </div>
        <div class="bg-indigo-100 p-4 rounded text-center">
            <div class="text-lg font-semibold text-indigo-800">{{ $stats['sent'] }}</div>
            <div class="text-sm text-indigo-600">Emails Sent</div>
        </div>
        <div class="bg-red-100 p-4 rounded text-center">
            <div class="text-lg font-semibold text-red-800">{{ $stats['missing_pdf'] }}</div>
            <div class="text-sm text-red-600">Missing PDF</div>
        </div>
    </div>

    {{-- Compact Filter Form --}}
<form method="GET" class="mb-4 flex flex-wrap gap-2 bg-white p-3 rounded shadow">
    <input type="text" name="user" value="{{ request('user') }}" placeholder="User name"
           class="border rounded p-2 flex-1 min-w-[150px]" />

    <input type="text" name="session" value="{{ request('session') }}" placeholder="Session title"
           class="border rounded p-2 flex-1 min-w-[150px]" />

    <select name="status" class="border rounded p-2 min-w-[120px]">
        <option value="">All Status</option>
        <option value="pending" @selected(request('status')=='pending')>Pending</option>
        <option value="issued" @selected(request('status')=='issued')>Issued</option>
        <option value="sent" @selected(request('status')=='sent')>Sent</option>
    </select>

    <input type="date" name="from" value="{{ request('from') }}" class="border rounded p-2 min-w-[120px]" />
    <!-- <input type="date" name="to" value="{{ request('to') }}" class="border rounded p-2 min-w-[120px]" /> -->

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Filter
    </button>

    <!-- <a href="{{ route('admin.certificates.create') }}"
       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        + Generate
    </a> -->
</form>


    {{-- Table --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full border divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Certificate No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">User</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Session</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Issued At</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Verify</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($certificates as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-500">{{ $c->id }}</td>
                    <td class="px-4 py-2 font-medium">{{ $c->cert_no }}</td>
                    <td class="px-4 py-2 text-sm">{{ $c->user?->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $c->session?->session_number ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $c->status }}</td>
                    <td class="px-4 py-2 text-sm">{{ $c->issued_at }}</td>
                    <td class="px-4 py-2 text-sm">
                        <a href="{{ route('certificates.verify.hash', $c->verification_hash) }}" class="text-blue-600 underline">
                            Verify
                        </a>
                    </td>
                    <td class="px-4 py-2 text-right text-sm">
                        <a href="{{ route('admin.certificates.show', $c->id) }}" class="text-indigo-600 mr-2">view</a>
                        <form action="{{ route('admin.certificates.destroy', $c->id) }}" method="POST" class="inline">
                            @csrf
                            <!-- @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button> -->
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-400">No certificates found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $certificates->links() }}
        </div>
    </div>
</div>
@endsection
