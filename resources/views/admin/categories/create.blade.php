@extends('layouts.admin')

@section('title', 'เพิ่มหมวดหมู่ใหม่')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg" x-data="categoryForm()">
    <h1 class="text-2xl font-bold mb-6">เพิ่มหมวดหมู่ใหม่</h1>

    <template x-if="errors.length">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                <template x-for="error in errors" :key="error">
                    <li x-text="error"></li>
                </template>
            </ul>
        </div>
    </template>

    <form @submit.prevent="confirmSubmit">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">กลุ่ม (Group):</label>
            <input type="text" x-model="form.group" placeholder="เช่น A, B, C, D, E, F"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">ชื่อหมวดหมู่:</label>
            <input type="text" x-model="form.name"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div class="flex items-center mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">
                บันทึก
            </button>
            <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:underline">
                ยกเลิก
            </a>
        </div>
    </form>
</main>

<script>
function categoryForm() {
    return {
        form: { group: '', name: '' },
        errors: [],
        confirmSubmit() {
            this.errors = [];

            if(!this.form.group) this.errors.push('กรุณากรอกกลุ่ม');
            if(!this.form.name) this.errors.push('กรุณากรอกชื่อหมวดหมู่');
            if(this.errors.length) return;

            Swal.fire({
                title: 'ยืนยันการบันทึก?',
                text: "คุณต้องการบันทึกหมวดหมู่นี้หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if(result.isConfirmed) {
                    fetch('{{ route("admin.categories.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(async res => {
                        const data = await res.json();
                        if(res.status === 422) {
                            this.errors = Object.values(data.errors).flat();
                            throw new Error('Validation error');
                        }
                        return data;
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route("admin.categories.index") }}';
                        });
                    })
                    .catch(err => {
                        if(err.message !== 'Validation error') {
                            Swal.fire({
                                title: 'ผิดพลาด!',
                                text: 'ไม่สามารถบันทึกหมวดหมู่ได้',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        }
    }
}
</script>
@endsection
