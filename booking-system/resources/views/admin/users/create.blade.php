<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Добави потребител
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6">

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
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Име *</label>
                    <input name="name" 
                           class="border p-2 w-full rounded" 
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Email *</label>
                    <input type="email" 
                           name="email" 
                           class="border p-2 w-full rounded" 
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Парола *</label>
                    <input type="password" 
                           name="password" 
                           class="border p-2 w-full rounded"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Минимум 8 символа</p>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Потвърди парола *</label>
                    <input type="password" 
                           name="password_confirmation" 
                           class="border p-2 w-full rounded"
                           required>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_admin" 
                               class="mr-2"
                               {{ old('is_admin') ? 'checked' : '' }}>
                        <span class="font-semibold">Администратор</span>
                    </label>
                    <p class="text-sm text-gray-500 mt-1">Администраторите имат пълен достъп до системата</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                        💾 Създай потребител
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">
                        ← Назад
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>