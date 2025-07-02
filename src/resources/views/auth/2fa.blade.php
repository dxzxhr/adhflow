<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enable Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
            <p class="mb-4">
                Сканируйте QR-код, потом введите 6-значный код:
            </p>

            {{-- 💡 выводим картинку --}}
            <img src="{{ $qr }}" alt="QR Code" class="mx-auto mb-4">

            <form method="POST" action="{{ route('twofactor.enable') }}" class="space-y-4 text-center">
                @csrf
                <input name="code"
                       maxlength="6"
                       placeholder="123456"
                       class="border rounded text-center w-1/2"
                       required>

                @error('code')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror

                <x-primary-button>Confirm</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
