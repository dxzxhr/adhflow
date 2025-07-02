<x-app-layout>
<x-slot name="header"><h2 class="text-xl">{{ isset($site)?'Редактировать':'Новый сайт' }}</h2></x-slot>

<form method="POST" action="{{ isset($site) ? route('sites.update',$site) : route('sites.store') }}" class="max-w-md space-y-4">
    @csrf
    @if(isset($site)) @method('PATCH') @endif

    <div>
        <label class="block">Домен</label>
        <input name="domain" value="{{ old('domain', $site->domain ?? '') }}" required class="border rounded w-full">
        @error('domain') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block">Ниша (IAB)</label>
        <input name="niche" value="{{ old('niche', $site->niche ?? '') }}" class="border rounded w-full">
    </div>

    <x-primary-button>{{ isset($site)?'Сохранить':'Отправить' }}</x-primary-button>
</form>
</x-app-layout>
