<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="FirstName" :value="__('FirstName')" />
            <x-text-input id="FirstName" class="block mt-1 w-full" type="text" name="FirstName" :value="old('FirstName')" required autofocus autocomplete="FirstName" />
            <x-input-error :messages="$errors->get('FirstName')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="MiddleName" :value="__('MiddleName')" />
            <x-text-input id="MiddleName" class="block mt-2 w-full" type="text" name="MiddleName" :value="old('MiddleName')" required autofocus autocomplete="MiddleName" />
            <x-input-error :messages="$errors->get('MiddleName')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="LatName" :value="__('LastName')" />
            <x-text-input id="LastName" class="block mt-2 w-full" type="text" name="LastName" :value="old('LastName')" required autofocus autocomplete="LastName" />
            <x-input-error :messages="$errors->get('LastName')" class="mt-2" />
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
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
