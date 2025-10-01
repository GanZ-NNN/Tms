<x-guest-layout>
    <!-- <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4"> -->
        <!-- <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 sm:p-10"> -->

            <!-- Header -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/KKU_SLA_Logo.svg.png') }}" class="mx-auto w-20 h-20 object-contain">
                <h2 class="mt-4 text-2xl font-bold text-gray-800 dark:text-gray-100">ยืนยันรหัส OTP</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">
                    กรอกรหัส 6 หลักที่ส่งไปยังอีเมลของคุณ
                </p>
            </div>

            <form method="POST" action="{{ route('password.verify.code') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Code -->
                <div>
                    <x-input-label for="code" :value="__('รหัสยืนยัน')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="code"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-orange-400 focus:border-orange-400"
                        type="text" name="code" maxlength="6" required autofocus />
                    <x-input-error :messages="$errors->get('code')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Submit -->
                <div class="flex justify-center">
                    <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                        ยืนยันรหัส
                    </x-primary-button>
                </div>
            </form>
        <!-- </div> -->
    <!-- </div> -->
</x-guest-layout>
