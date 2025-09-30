<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
            {{ __('ลืมรหัสผ่าน?') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
            {{ __('กรอกอีเมลของคุณ ระบบจะส่งรหัสยืนยัน (OTP 6 หลัก) ไปยังอีเมลเพื่อใช้ในการเปลี่ยนรหัสผ่าน') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('อีเมลของคุณ')" class="mb-1 font-semibold" />
                <x-text-input id="email"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <div class="flex items-center justify-center">
                <x-primary-button class="px-6 py-2 w-full justify-center rounded-lg text-base font-medium shadow-md transition duration-150 ease-in-out">
                    {{ __('ส่งรหัสยืนยัน') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                {{ __('กลับไปหน้าเข้าสู่ระบบ') }}
            </a>
        </div>
    </div>
</x-guest-layout>
