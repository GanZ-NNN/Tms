@extends('layouts.admin')

@section('title', 'จัดการผู้ใช้งาน / ผู้สอน')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg" x-data="{ tab: 'users' }">

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อหรืออีเมล" class="flex-1 px-4 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-orange-400">
        <button type="submit" class="bg-orange-400 text-white px-4 py-2 rounded-r hover:bg-orange-500 transition-colors duration-200">ค้นหา</button>
    </form>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6 flex space-x-4">
        <button
            @click="tab = 'users'"
            :class="tab === 'users'
                ? 'text-orange-400 border-b-2 border-orange-400 font-semibold transition-colors duration-300'
                : 'text-gray-500 font-medium hover:text-orange-400 transition-colors duration-300'"
            class="py-2 px-4"
        >
            จัดการผู้ใช้งาน
        </button>
        <button
            @click="tab = 'trainers'"
            :class="tab === 'trainers'
                ? 'text-orange-400 border-b-2 border-orange-400 font-semibold transition-colors duration-300'
                : 'text-gray-500 font-medium hover:text-orange-400 transition-colors duration-300'"
            class="py-2 px-4"
        >
            จัดการผู้สอน
        </button>
    </div>

    <!-- Users Table -->
    <div x-show="tab === 'users'"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     x-cloak
>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">ผู้ใช้งาน</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">➕ เพิ่มผู้ใช้งาน</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">ชื่อผู้ใช้งาน</th>
                        <th class="px-6 py-3 font-semibold">อีเมล</th>
                        <th class="px-6 py-3 font-semibold">สิทธิ์</th>
                        <th class="px-6 py-3 font-semibold text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-4">{{ $user->id }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->role }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-400 text-white px-4 py-2 rounded-full hover:bg-yellow-500 transition-colors duration-200">✏️ แก้ไข</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบผู้ใช้นี้?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-colors duration-200">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">ไม่พบผู้ใช้งาน</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $users->appends(request()->query())->links() }}</div>
    </div>

    <!-- Trainers Table -->
    <div x-show="tab === 'trainers'"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     x-cloak
>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">ผู้สอน</h2>
        <a href="{{ route('admin.trainers.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">➕ เพิ่มผู้สอน</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">ชื่อผู้สอน</th>
                        <th class="px-6 py-3 font-semibold">อีเมล</th>
                        <th class="px-6 py-3 font-semibold">เบอร์โทร</th>
                        <th class="px-6 py-3 font-semibold">expertise</th>
                        <th class="px-6 py-3 font-semibold text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($trainers as $trainer)
                    <tr>
                        <td class="px-6 py-4">{{ $trainer->id }}</td>
                        <td class="px-6 py-4">{{ $trainer->name }}</td>
                        <td class="px-6 py-4">{{ $trainer->email }}</td>
                        <td class="px-6 py-4">{{ $trainer->phone_number }}</td>
                        <td class="px-6 py-4">{{ $trainer->expertise }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="bg-yellow-400 text-white px-4 py-2 rounded-full hover:bg-yellow-500 transition-colors duration-200">✏️ แก้ไข</a>
                            <form action="{{ route('admin.trainers.destroy',$trainer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบผู้ใช้นี้?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-colors duration-200">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">ไม่พบผู้สอน</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $trainers->appends(request()->query())->links() }}</div>
    </div>

</main>
@endsection
