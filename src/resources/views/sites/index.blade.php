<x-app-layout>
<x-slot name="header"><h2 class="text-xl">Мои площадки</h2></x-slot>

<a href="{{ route('sites.create') }}" class="mb-4 inline-block px-3 py-2 bg-indigo-600 text-white rounded">
    + Добавить сайт
</a>

{{-- фильтры --}}
@php $status = request('status'); @endphp
<div class="space-x-4 mb-3">
    @foreach(['pending'=>'На модерации','active'=>'Активны','rejected'=>'Отклонены'] as $k=>$v)
        <a href="?status={{ $k }}" class="{{ $status==$k?'font-bold':'' }}">{{ $v }}</a>
    @endforeach
</div>

<table class="w-full bg-white shadow">
<thead><tr class="bg-gray-100">
    <th class="p-2">ID</th>
    <th class="p-2">Домен</th>
    <th class="p-2">Ниша</th>
    <th class="p-2">Статус</th>
    <th class="p-2"></th>
</tr></thead>
<tbody>
@foreach($sites as $s)
<tr class="border-t">
    <td class="p-2">{{ $s->id }}</td>
    <td class="p-2">{{ $s->domain }}</td>
    <td class="p-2">{{ $s->niche }}</td>
    <td class="p-2">{{ ucfirst($s->status) }}</td>
    <td class="p-2">
        <a href="{{ route('sites.edit',$s) }}" class="text-indigo-600">Edit</a>
    </td>
</tr>
@endforeach
</tbody>
</table>

{{ $sites->withQueryString()->links() }}
</x-app-layout>
