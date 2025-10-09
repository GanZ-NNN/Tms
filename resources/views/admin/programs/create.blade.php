@extends('layouts.admin')

@section('title', 'เพิ่มหลักสูตร')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg" x-data="programForm()">
    <h1 class="text-2xl font-bold mb-6">เพิ่มหลักสูตร</h1>

    {{-- Validation Errors --}}
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
        {{-- Title --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" x-model="form.title" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select x-model="form.category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Detail --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Detail</label>
            <textarea x-model="form.detail" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
            <input type="file" @change="handleFileUpload" class="w-full">
        </div>

        {{-- Buttons --}}
        <div class="flex items-center mt-6">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors duration-200">
                💾 บันทึก
            </button>
            <a href="{{ route('admin.programs.index') }}" class="ml-4 text-gray-600 hover:underline">
                ⬅ ยกเลิก
            </a>
        </div>
    </form>
</main>

<script>
function programForm() {
    return {
        form: {
            title: '',
            category_id: '',
            detail: '',
            image_file: null
        },
        errors: [],
        handleFileUpload(event) {
            this.form.image_file = event.target.files[0];
        },
        confirmSubmit() {
            this.errors = [];

            if(!this.form.title) this.errors.push('กรุณากรอก Title');
            if(!this.form.category_id) this.errors.push('กรุณาเลือก Category');

            if(this.errors.length) return;

            Swal.fire({
                title: 'ยืนยันการบันทึก?',
                text: "คุณต้องการเพิ่มหลักสูตรนี้หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if(result.isConfirmed){
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('title', this.form.title);
                    formData.append('category_id', this.form.category_id);
                    formData.append('detail', this.form.detail);
                    if(this.form.image_file) formData.append('image', this.form.image_file);

                    fetch('{{ route("admin.programs.store") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.errors){
                            this.errors = Object.values(data.errors).flat();
                            throw new Error('Validation error');
                        }
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: 'หลักสูตรถูกบันทึกเรียบร้อยแล้ว',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route("admin.programs.index") }}';
                        });
                    })
                    .catch(err => {
                        if(err.message !== 'Validation error'){
                            Swal.fire({
                                title: 'ผิดพลาด!',
                                text: 'ไม่สามารถบันทึกหลักสูตรได้',
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
