<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10">

            <!-- Logo / Header -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/KKU_SLA_Logo.svg.png') }}" alt="KKU SLA Logo" class="mx-auto w-24 h-24 object-contain">
                <h1 class="mt-4 text-3xl font-bold text-gray-800 dark:text-gray-100">เข้าสู่ระบบ</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">กรุณากรอกอีเมลและรหัสผ่านของคุณ</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input
                        id="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input
                        id="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-orange-500 focus:ring-orange-400 dark:focus:ring-orange-400">
                        <span class="ml-2 text-sm">จดจำฉัน</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:underline">
                            ลืมรหัสผ่าน?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <x-primary-button class="w-full bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                        เข้าสู่ระบบ
                    </x-primary-button>
                </div>
            </form>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300 dark:border-gray-600">
                <span class="px-4 text-gray-500 dark:text-gray-400 text-sm">หรือ</span>
                <hr class="flex-grow border-gray-300 dark:border-gray-600">
            </div>

            <!-- Register Link -->
            <p class="text-center text-gray-600 dark:text-gray-400 text-sm">
                ยังไม่มีบัญชี?
                <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold">สมัครสมาชิก</a>
            </p>
        </div>
    </div>
</x-guest-layout>
