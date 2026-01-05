<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Редактирай тип обект
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('admin.object-types.update', $objectType) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Име на тип обект *</label>
                    <input name="name" 
                           class="border p-2 w-full rounded" 
                           value="{{ old('name', $objectType->name) }}"
                           required>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                        💾 Запази промени
                    </button>
                    <a href="{{ route('admin.object-types.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">
                        ← Назад
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>