<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md text-center">
            <h1 class="text-xl font-bold mb-4">ยืนยันอีเมลของคุณ</h1>
            <p class="mb-4">โปรดตรวจสอบอีเมลและคลิกที่ลิงก์ยืนยันบัญชี</p>

            @if(session('message'))
                <p class="text-green-500 mb-4">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                    ส่งลิงก์ยืนยันใหม่
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
