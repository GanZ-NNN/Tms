<x-guest-layout>
    <form method="POST" action="{{ route('password.update.with.code') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="code" value="{{ $code }}">

        <div>
            <x-input-label for="password" :value="__('รหัสผ่านใหม่')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('ยืนยันรหัสผ่านใหม่')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>เปลี่ยนรหัสผ่าน</x-primary-button>
        </div>
    </form>
</x-guest-layout>
