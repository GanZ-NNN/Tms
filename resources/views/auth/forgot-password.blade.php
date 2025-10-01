<x-guest-layout>


            <!-- Logo / Header -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/KKU_SLA_Logo.svg.png') }}" class="mx-auto w-20 h-20 object-contain">
                <h2 class="mt-4 text-2xl font-bold text-gray-800 dark:text-gray-100">ลืมรหัสผ่าน?</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">
                    กรอกอีเมล ระบบจะส่งรหัสยืนยัน (OTP 6 หลัก) ไปยังอีเมลของคุณ
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('อีเมลของคุณ')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input
                        id="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-orange-400 focus:border-orange-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Submit -->
                <div class="flex justify-center">
                    <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                        ส่งรหัสยืนยัน
                    </x-primary-button>
                </div>
            </form>

            <!-- Back to Login -->
            <p class="text-center text-gray-600 dark:text-gray-400 text-sm mt-6">
                <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-semibold">
                    กลับไปหน้าเข้าสู่ระบบ
                </a>
            </p>
</x-guest-layout>
