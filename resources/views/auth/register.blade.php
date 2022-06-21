<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div>
                <x-label for="nameuser" :value="__('Username')" />

                <x-input id="nameuser" class="block mt-1 w-full" type="text" name="nameuser" :value="old('nameuser')" required autofocus />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="nama" :value="__('Nama')" />

                <x-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required />
            </div>

            <!-- Level -->
            <div class="mt-4">
                <x-label for="level" :value="__('Level')" />

                <select name="level" id="level">
                    <option value="0">0 - Superadmin</option>
                    <option value="1">1 - User HO</option>
                    <option value="2">2 - Admin Site</option>
                    <option value="3">3 - User Site</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required />
            </div>

            
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
