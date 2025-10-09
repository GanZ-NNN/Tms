@extends('layouts.admin')

@section('title', 'จัดการหมวดหมู่')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">

    <h1 class="text-2xl font-bold mb-6">หมวดหมู่ทั้งหมด</h1>

    <a href="{{ route('admin.categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">
        ➕ เพิ่มหมวดหมู่
    </a>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">กลุ่ม</th>
                    <th class="px-6 py-3">ชื่อหมวดหมู่</th>
                    <th class="px-6 py-3 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4">{{ $category->id }}</td>
                        <td class="px-6 py-4">{{ $category->group }}</td>
                        <td class="px-6 py-4">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">
                                ✏️ แก้ไข
                            </a>
                            <button class="delete-btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                    data-id="{{ $category->id }}">
                                🗑️ ลบ
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">ไม่พบหมวดหมู่</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณต้องการลบหมวดหมู่นี้จริงหรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(err => {
                    Swal.fire('ผิดพลาด!', 'ไม่สามารถลบหมวดหมู่ได้', 'error');
                });
            }
        });
    });
});
</script>
@endsection
