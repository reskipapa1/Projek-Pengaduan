<x-guest-layout>
    
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa password kamu? tidak masalah. beritahu kami alamat email kamu dan kami akan mengirimkan link reset password yang akan memungkinkan kamu untuk memilih password baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

         
        <div class="flex items-center mt-4 w-full">
            <a href="{{ route('login') }}"
                class="flex justify-start bg-green-600 text-white ml-4 px-4 py-2 rounded">
                    {{ __('KEMBALI') }}
            </a>
            <x-primary-button class="ml-7">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
