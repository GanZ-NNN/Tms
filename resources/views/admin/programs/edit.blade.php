<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl ...">
            {{ __('Edit Course Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto ...">
            <div class="bg-white ... p-6">
                <form action="{{ route('admin.programs.update', $program) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- ฟอร์มแก้ไข Title, Description, Category ของ Program --}}
                    {{-- ... ใช้โค้ดตัวเต็มที่เราทำเสร็จแล้ว ... --}}

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.programs.index') }}">Cancel</a>
                        <x-primary-button class="ml-4">Update Template</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>