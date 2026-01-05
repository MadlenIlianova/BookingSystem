<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏡 Къщи за почивка
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('admin.houses.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                   ➕ Добави къща
                </a>
            @else
                <div></div>
            @endif
        </div>

        <form method="GET" class="mb-4 bg-white p-4 rounded shadow">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <input type="text" name="search" placeholder="Търси по име..."
                       value="{{ request('search') }}"
                       class="border p-2 rounded">
                
                <select name="settlement_id" class="border p-2 rounded">
                    <option value="">Всички места</option>
                    @foreach($settlements as $settlement)
                        <option value="{{ $settlement->id }}" 
                                @selected(request('settlement_id') == $settlement->id)>
                            {{ $settlement->name }}
                        </option>
                    @endforeach
                </select>

                <select name="object_type_id" class="border p-2 rounded">
                    <option value="">Всички типове</option>
                    @foreach($objectTypes as $type)
                        <option value="{{ $type->id }}" 
                                @selected(request('object_type_id') == $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    🔍 Търси
                </button>
            </div>
        </form>

        @php
            $direction = request('direction') === 'asc' ? 'desc' : 'asc';
            $isAdmin = auth()->check() && auth()->user()->is_admin;
        @endphp

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left border">Снимка</th>
                        <th class="p-3 text-left border">
                            <a href="?sort=name&direction={{ $direction }}">
                                Име
                                @if(request('sort')==='name')
                                    {{ request('direction')==='asc'?'▲':'▼' }}
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-left border">Населено място</th>
                        <th class="p-3 text-left border">
                            <a href="?sort=beds_count&direction={{ $direction }}">
                                Брой легла
                                @if(request('sort')==='beds_count')
                                    {{ request('direction')==='asc'?'▲':'▼' }}
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-left border">Тип обект</th>
                        @if($isAdmin)
                            <th class="p-3 text-left border">Действия</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($houses as $house)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">
                                @if($house->mainImage)
                                    <img src="{{ asset('storage/' . $house->mainImage->path) }}" 
                                         class="w-20 h-20 object-cover rounded"
                                         alt="{{ $house->name }}">
                                @elseif($house->images->first())
                                    <img src="{{ asset('storage/' . $house->images->first()->path) }}" 
                                         class="w-20 h-20 object-cover rounded"
                                         alt="{{ $house->name }}">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Няма снимка</span>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="p-3 border font-semibold">{{ $house->name }}</td>
                            <td class="p-3 border">{{ $house->settlement->name }}</td>
                            <td class="p-3 border">{{ $house->beds_count }}</td>
                            <td class="p-3 border">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                    {{ $house->objectType->name }}
                                </span>
                            </td>
                            
                            @if($isAdmin)
                                <td class="p-3 border">
                                    <a href="{{ route('admin.houses.edit', $house) }}" 
                                       class="text-blue-600 hover:text-blue-800 mr-3">
                                       ✏️ Редактирай
                                    </a>

                                    <form method="POST" 
                                          action="{{ route('admin.houses.destroy', $house) }}" 
                                          class="inline"
                                          onsubmit="return confirm('Сигурни ли сте?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            🗑️ Изтрий
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isAdmin ? 6 : 5 }}" class="p-6 text-center text-gray-500">
                                Няма намерени къщи за почивка.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $houses->links() }}
        </div>

    </div>
</x-app-layout>./vendor/bin/sail artisan tinker