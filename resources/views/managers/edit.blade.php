<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('managers.index') }}" class="text-white hover:text-gray-400">
                {{ __('managers.edit.title') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('managers.edit.edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('managers.update', $manager->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label">{{ __('managers.edit.name') }}</label>
                        <input type="text" name="name" id="name"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') is-invalid @enderror"
                               value="{{ old('name', $manager->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div class="mb-4">
                        <label for="role" class="form-label">{{ __('managers.edit.role') }}</label>
                        <select name="role" id="role" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('role') is-invalid @enderror">
                            <option value="manager" {{ $manager->role == 'manager' ? 'selected' : '' }}>Menedzser</option>
                            <option value="admin" {{ $manager->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('managers.edit.email') }}</label>
                        <input type="email" name="email" id="email"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') is-invalid @enderror"
                               value="{{ old('email', $manager->email) }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-4">
                        <label for="phone" class="form-label">{{ __('managers.edit.phone') }}</label>
                        <input type="text" name="phone" id="phone"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $manager->phone) }}">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('managers.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('managers.edit.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('managers.edit.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>