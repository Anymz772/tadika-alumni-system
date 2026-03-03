<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        'Terima kasih kerana mendaftar! Sebelum memulakan, bolehkah anda mengesahkan alamat emel anda dengan mengklik pautan yang baru sahaja kami hantar? Jika anda tidak menerima emel tersebut, kami dengan senang hati akan menghantar satu lagi.'
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            'Pautan pengesahan baru telah dihantar ke alamat emel yang anda berikan semasa pendaftaran.'
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    'Hantar Semula Emel Pengesahan' 
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                'Log Keluar'
            </button>
        </form>
    </div>
</x-guest-layout>
