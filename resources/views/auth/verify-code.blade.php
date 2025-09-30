<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('กรอกรหัส 6 หลักที่ส่งไปยังอีเมลของคุณ') }}
    </div>

    <form method="POST" action="{{ route('password.verify.code') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <x-input-label for="code" :value="__('รหัสยืนยัน')" />
            <x-text-input id="code" class="block mt-1 w-full"
                          type="text"
                          name="code"
                          maxlength="6"
                          required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('ยืนยันรหัส') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
