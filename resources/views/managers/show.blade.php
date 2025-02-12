<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('managers.index') }}" class="text-white hover:text-gray-400">
                {{ __('managers.show.title') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('managers.show.details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('managers.show.name') }}:</strong> {{ $manager->name }}</p>
                        <p><strong>{{ __('managers.show.role') }}:</strong> {{ $manager->role }}</p>
                        <p><strong>{{ __('managers.show.email') }}:</strong> {{ $manager->email }}</p>
                        <p><strong>{{ __('managers.show.phone') }}:</strong> {{ $manager->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>