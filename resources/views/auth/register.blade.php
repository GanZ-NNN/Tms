<x-guest-layout>
    <!-- <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8"> -->
            <!-- Header / Logo -->
            <div class="text-center mb-6">
                <img src="{{ asset('assets/img/KKU_SLA_Logo.svg.png') }}" alt="KKU SLA Logo" class="mx-auto w-20 h-20 object-contain">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-4">สมัครสมาชิก</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">กรุณากรอกข้อมูลเพื่อสร้างบัญชี</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="phone_number" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="text" name="phone_number" :value="old('phone_number')" autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Occupation -->
                <div>
                    <x-input-label for="occupation" :value="__('Occupation')" class="font-semibold text-gray-700 dark:text-gray-300"/>

                    <select id="occupation" name="occupation"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400">
                        <option value="">-- เลือกอาชีพ/สถานะ --</option>
                        <option value="นักศึกษาในคณะ" {{ old('occupation') == 'นักศึกษาในคณะ' ? 'selected' : '' }}>นักศึกษาในคณะ</option>
                        <option value="นักศึกษามข" {{ old('occupation') == 'นักศึกษามข' ? 'selected' : '' }}>นักศึกษามข</option>
                        <option value="อาจารย์ในคณะ" {{ old('occupation') == 'อาจารย์ในคณะ' ? 'selected' : '' }}>อาจารย์ในคณะ</option>
                        <option value="อาจารย์มข" {{ old('occupation') == 'อาจารย์มข' ? 'selected' : '' }}>อาจารย์มข</option>
                        <option value="บุคคลภายนอก" {{ old('occupation') == 'บุคคลภายนอก' ? 'selected' : '' }}>บุคคลภายนอก</option>
                    </select>

                    <x-input-error :messages="$errors->get('occupation')" class="mt-2 text-sm text-red-500"/>
                </div>


                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold text-gray-700 dark:text-gray-300"/>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500"/>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                        สมัครสมาชิก
                    </x-primary-button>
                </div>


            </form>

            <!-- Divider -->
            <div class="flex items-center my-6 text-center">
                <hr class="flex-grow border-gray-300 dark:border-gray-600">
                <span class="px-4 text-gray-500 dark:text-gray-400 text-sm">หรือ</span>
                <hr class="flex-grow border-gray-300 dark:border-gray-600">
            </div>

            <!-- Login Link -->
            <p class="text-center text-gray-600 dark:text-gray-400 text-sm">
                มีบัญชีแล้ว?
                <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-semibold">เข้าสู่ระบบ</a>
            </p>
        <!-- </div>
    </div> -->
</x-guest-layout>
