<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📍 Външни места
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.settlements.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                   ➕ Добави населено място
                </a>
            @endif
        </div>

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left border">Населено място</th>
                        <th class="p-3 text-left border">Брой къщи</th>
                        @if(auth()->user()->is_admin)
                            <th class="p-3 text-left border">Действия</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($settlements as $settlement)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border font-semibold">{{ $settlement->name }}</td>
                            <td class="p-3 border">{{ $settlement->houses_count }}</td>
                            
                            @if(auth()->user()->is_admin)
                                <td class="p-3 border">
                                    <a href="{{ route('admin.settlements.edit', $settlement) }}" 
                                       class="text-blue-600 hover:text-blue-800 mr-3">
                                       ✏️ Редактирай
                                    </a>

                                    @if($settlement->houses_count == 0)
                                        <form method="POST" 
                                              action="{{ route('admin.settlements.destroy', $settlement) }}" 
                                              class="inline"
                                              onsubmit="return confirm('Сигурни ли сте?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                🗑️ Изтрий
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400" title="Не може да се изтрие - има свързани къщи">
                                            🗑️ Изтрий
                                        </span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->is_admin ? 3 : 2 }}" class="p-6 text-center text-gray-500">
                                Няма добавени населени места.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $settlements->links() }}
        </div>

    </div>
</x-app-layout>