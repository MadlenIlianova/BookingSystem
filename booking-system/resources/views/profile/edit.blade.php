<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
        
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Информация за профила
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Обновете информацията на вашия профил и имейл адрес.
                        </p>
                    </header>

                    @if(session('status') === 'profile-updated')
                        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 mt-4">
                            Профилът е обновен успешно!
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Име</label>
                            <input id="name" name="name" type="text" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" 
                                   value="{{ old('name', $user->name) }}" 
                                   required autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" name="email" type="email" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                                Запази
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Изтриване на акаунт
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            След като вашият акаунт бъде изтрит, всички негови ресурси и данни ще бъдат изтрити завинаги.
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6">
                        @csrf
                        @method('delete')

                        <div>
                            <label for="password_delete" class="block font-medium text-sm text-gray-700">Парола</label>
                            <input id="password_delete" name="password" type="password" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" 
                                   placeholder="Въведете паролата си за потвърждение">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md" 
                                    onclick="return confirm('Сигурни ли сте, че искате да изтриете акаунта си?')">
                                Изтрий акаунт
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>