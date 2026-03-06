<x-guest-layout>

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
        <p class="text-sm text-gray-500">Login ke akun anda</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-lg bg-green-100 p-3 text-sm text-green-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input class="block mt-1 w-full rounded-lg"
                type="email" name="email"
                :value="old('email')" required />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input class="block mt-1 w-full rounded-lg"
                type="password" name="password" required />
        </div>

        <div class="flex justify-between items-center text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" class="text-green-600 rounded">
                Remember me
            </label>

            <a href="#" class="text-green-600 hover:underline">
                Forgot?
            </a>
        </div>

        <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700">
            Login
        </x-primary-button>

    </form>

</x-guest-layout>