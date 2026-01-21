<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👥 Потребители
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('admin.users.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded">
               ➕ Добави потребител
            </a>
        </div>

        <form method="GET" class="mb-4 bg-white p-4 rounded shadow">
            <div class="flex gap-3">
                <input type="text" name="search" placeholder="Търси по име или email..."
                       value="{{ request('search') }}"
                       class="border p-2 rounded flex-1">
                
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    🔍 Търси
                </button>
            </div>
        </form>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left border">Име</th>
                        <th class="p-3 text-left border">Email</th>
                        <th class="p-3 text-left border">Роля</th>
                        <th class="p-3 text-left border">Създаден</th>
                        <th class="p-3 text-left border">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border font-semibold">{{ $user->name }}</td>
                            <td class="p-3 border">{{ $user->email }}</td>
                            <td class="p-3 border">
                                @if($user->is_admin)
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-semibold">
                                        🛡️ Администратор
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">
                                        Потребител
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 border text-sm text-gray-600">
                                {{ $user->created_at->format('d.m.Y') }}
                            </td>
                            <td class="p-3 border">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-blue-600 hover:text-blue-800 mr-3">
                                   ✏️ Редактирай
                                </a>

                                @if($user->id !== auth()->id())
                                    <form method="POST" 
                                          action="{{ route('admin.users.destroy', $user) }}" 
                                          class="inline"
                                          onsubmit="return confirm('Сигурни ли сте?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            🗑️ Изтрий
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Няма намерени потребители.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>