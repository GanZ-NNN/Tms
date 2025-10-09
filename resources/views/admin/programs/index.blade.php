@extends('layouts.admin')

@section('title', 'จัดการโปรแกรม / รอบอบรม')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg"
     x-data="programsData()">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">โปรแกรม & รอบอบรม</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.programs.create') }}"
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">
               ➕ เพิ่มโปรแกรม
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="mb-6 flex items-end space-x-4">
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700">ค้นหาชื่อโปรแกรม</label>
            <input type="text" id="search" x-model.debounce.300ms="searchTerm" placeholder="ค้นหา..."
                   class="mt-1 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category" x-model="selectedCategory"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="">All Categories</option>
                <template x-for="category in categories" :key="category.id">
                    <option :value="category.id" x-text="category.name"></option>
                </template>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold text-center">ID</th>
                    <th class="px-6 py-3 font-semibold text-center">รูป</th>
                    <th class="px-6 py-3 font-semibold text-left">ชื่อโปรแกรม</th>
                    <th class="px-6 py-3 font-semibold text-center">Category</th>
                    <th class="px-6 py-3 font-semibold text-center">จัดการ</th>
                </tr>
            </thead>

            <template x-for="program in filteredPrograms()" :key="program.id">
                <tbody class="divide-y divide-gray-200 border-t" x-data="{ open: false }">
                    {{-- Row Program --}}
                    <tr class="bg-gray-50 hover:bg-gray-100">
                        <td class="px-6 py-4 text-center" x-text="program.id"></td>
                        <td class="px-6 py-4 text-center">
                            <template x-if="program.image">
                                <img :src="`/storage/${program.image}`" :alt="program.title"
                                     class="w-16 h-16 object-cover rounded mx-auto">
                            </template>
                            <template x-if="!program.image">
                                <span>-</span>
                            </template>
                        </td>
                        <td class="px-6 py-4">
                            <button @click="open = !open"
                                    class="flex items-center justify-start space-x-2 w-full text-blue-600 hover:text-blue-800 font-bold text-left">
                                <span x-text="program.title"></span>
                                <svg class="w-4 h-4 transition-transform flex-shrink-0"
                                     :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center" x-text="program.category ? program.category.name : '-'"></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a :href="`/admin/programs/${program.id}/edit`"
                                   class="inline-flex items-center justify-center w-24 px-3 py-2 text-xs font-bold text-gray-800 uppercase bg-yellow-400 rounded-full hover:bg-yellow-500">
                                   ✏️ แก้ไข
                                </a>
                                <a :href="`/admin/programs/${program.id}/sessions/create`"
                                   class="inline-flex items-center justify-center w-32 px-3 py-2 text-xs font-bold text-white uppercase bg-blue-500 rounded-full hover:bg-blue-600">
                                   ➕ เพิ่มรอบอบรม
                                </a>
                                <form :action="`/admin/programs/${program.id}`" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="inline-flex items-center justify-center w-20 px-3 py-2 text-xs font-bold text-white uppercase bg-red-500 rounded-full hover:bg-red-600"
                                            @click="confirmDelete($event, program.id)">
                                        🗑️ ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Sessions --}}
                    <tr x-show="open" x-transition x-cloak>
                        <td colspan="5" class="p-0">
                            <div class="px-6 py-3">
                                <template x-if="program.sessions && program.sessions.length > 0">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="text-xs text-gray-500 border-b">
                                                <th class="py-2 text-left font-semibold">รอบที่</th>
                                                <th class="py-2 text-left font-semibold">ระดับ</th>
                                                <th class="py-2 text-left font-semibold">ผู้สอน</th>
                                                <th class="py-2 text-left font-semibold">วันที่</th>
                                                <th class="py-2 text-left font-semibold">สถานที่</th>
                                                <th class="py-2 text-left font-semibold">Capacity</th>
                                                <th class="py-2 text-left font-semibold">สถานะ</th>
                                                <th class="py-2 text-left font-semibold">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="session in program.sessions" :key="session.id">
                                                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                                    <td class="py-3" x-text="session.session_number || '-'"></td>
                                                    <td class="py-3">
                                                        <template x-if="session.level">
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800" x-text="session.level"></span>
                                                        </template>
                                                        <template x-if="!session.level">
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">-</span>
                                                        </template>
                                                    </td>
                                                    <td class="py-3" x-text="session.trainer ? session.trainer.name : 'N/A'"></td>
                                                    <td class="py-3" x-text="new Date(session.start_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })"></td>
                                                    <td class="py-3" x-text="session.location || '-'"></td>
                                                    <td class="py-3" x-text="session.capacity || 'N/A'"></td>
                                                    <td class="py-3">
                                                        <template x-if="session.status === 'completed'">
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                                        </template>
                                                        <template x-if="session.status === 'scheduled'">
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Scheduled</span>
                                                        </template>
                                                        <template x-if="session.status === 'cancelled'">
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                                        </template>
                                                    </td>
                                                    <td class="py-3">
                                                        <a :href="`/admin/programs/${program.id}/sessions/${session.id}/edit`"
                                                           class="text-yellow-600 hover:underline text-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </template>
                                <template x-if="!program.sessions || program.sessions.length === 0">
                                    <p class="text-center text-gray-500 py-4">No sessions found for this program.</p>
                                </template>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </template>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function programsData() {
    return {
        programs: @json($programs),
        categories: @json($categories),
        searchTerm: "{{ request('search', '') }}",
        selectedCategory: "",

        filteredPrograms() {
            return this.programs.filter(p =>
                p.title.toLowerCase().includes(this.searchTerm.toLowerCase()) &&
                (this.selectedCategory === '' || p.category_id == this.selectedCategory)
            );
        },

        confirmDelete(event, programId) {
            const form = event.target.closest('form');
            const action = form.action;

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "การลบนี้จะไม่สามารถย้อนกลับได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if(result.isConfirmed){
                    fetch(action, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value,
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: new FormData(form)
})
.then(res => res.ok ? res.json() : Promise.reject('Network response was not ok'))

                    .then(data => {
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // ลบ program จาก array
                            this.programs = this.programs.filter(p => p.id !== programId);
                        });
                    })
                    .catch(err => {
                        Swal.fire('ผิดพลาด!', 'ไม่สามารถลบข้อมูลได้', 'error');
                    });
                }
            });
        }
    }
}

// แสดง SweetAlert ถ้ามี session success
@if(session('success'))
Swal.fire({
    title: 'สำเร็จ!',
    text: '{{ session('success') }}',
    icon: 'success',
    timer: 2000,
    showConfirmButton: false
});
@endif
</script>
@endpush
