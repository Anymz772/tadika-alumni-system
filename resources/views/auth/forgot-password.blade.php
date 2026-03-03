<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        'Lupa kata laluan anda? Tiada masalah. Beritahu kami alamat emel anda dan kami akan menghantar pautan tetapan semula kata laluan yang akan membolehkan anda memilih yang baharu.'
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="user_email" :value="'Emel'" />
            <x-text-input id="user_email" class="block mt-1 w-full" type="email" name="user_email" :value="old('user_email')" required autofocus />
            <x-input-error :messages="$errors->get('user_email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                'Hantar Pautan Tetapan Semula Kata Laluan'
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>