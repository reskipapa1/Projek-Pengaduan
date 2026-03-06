<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
         <div class="flex gap-2 w-full">
        <div class="w-full">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nik &  -->
         <div class="w-full">
            <x-input-label for="Nik" :value="__('Nik')"/>
            <x-text-input id="Nik" class="block mt-1 w-full" type="text" name="Nik" :value="old('Nik')" required autocomplete="Nik" />
            <x-input-error :messages="$errors->get('Nik')" class="mt-2"/>
        </div>

        </div>

        <div class="flex gap-2 w-full pt-4">
         <!-- No Telp -->
        <div class="w-full">
            <x-input-label for="no_telp" :value="__('No Telp')"/>
            <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" required autocomplete="no_telp" />
            <x-input-error :messages="$errors->get('no_telp')" class="mt-2"/>       
        </div>

        <!-- Alamat -->
        <div class="w-full">
    <x-input-label for="alamat" :value="__('Alamat')" />
    
    <select 
        id="alamat" 
        name="alamat" 
        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        required
    >
        <option value="" disabled selected>Pilih Alamat...</option>
        
        {{-- Opsi Enum --}}
        <option value="Bukit_raya" {{ old('alamat') == 'Bukit_raya' ? 'selected' : '' }}>Bukit Raya</option>
        <option value="bina_widya" {{ old('alamat') == 'bina_widya' ? 'selected' : '' }}>Binawidya</option>
        <option value="marpoyan_damai" {{ old('alamat') == 'marpoyan_damai' ? 'selected' : '' }}>Marpoyan Damai</option>
        <option value="senapelan" {{ old('alamat') == 'senapelan' ? 'selected' : '' }}>Senapelan</option>
        <option value="rumbai" {{ old('alamat') == 'rumbai' ? 'selected' : '' }}>Rumbai</option>
    </select>


    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
</div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
