<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Добави къща за почивка
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
            <form method="POST" action="{{ route('admin.houses.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Име на къщата *</label>
                    <input name="name" 
                           class="border p-2 w-full rounded" 
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Населено място *</label>
                    <select name="settlement_id" class="border p-2 w-full rounded" required>
                        <option value="">Избери населено място</option>
                        @foreach($settlements as $settlement)
                            <option value="{{ $settlement->id }}" 
                                    @selected(old('settlement_id') == $settlement->id)>
                                {{ $settlement->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Брой легла *</label>
                    <input type="number" 
                           name="beds_count" 
                           class="border p-2 w-full rounded" 
                           value="{{ old('beds_count', 2) }}"
                           min="1"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Тип обект *</label>
                    <select name="object_type_id" class="border p-2 w-full rounded" required>
                        <option value="">Избери тип обект</option>
                        @foreach($objectTypes as $type)
                            <option value="{{ $type->id }}" 
                                    @selected(old('object_type_id') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Описание</label>
                    <textarea name="description" 
                              class="border p-2 w-full rounded" 
                              rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                        💾 Запази
                    </button>
                    <a href="{{ route('admin.houses.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">
                        ← Назад
                    </a>
                </div>    
                             <div class="mb-4">
    <label class="block font-semibold mb-2">Снимки</label>
    <input type="file" 
           name="images[]" 
           multiple
           accept="image/*"
           class="border p-2 w-full rounded">
    <p class="text-sm text-gray-500 mt-1">Можете да изберете няколко снимки наведнъж. Първата снимка ще бъде главна.</p>
</div>
        </div>
    </div>     
            </form>    
</x-app-layout>