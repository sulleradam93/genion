<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('job_positions.index') }}" class="text-white hover:text-gray-400">
                {{ __('job_positions.show.job_positions') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('job_positions.show.job_position_details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('job_positions.show.job_position') }}:</strong> {{ $jobPosition->title }}</p>
                        <p><strong>{{ __('job_positions.show.description') }}:</strong> {{ $jobPosition->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>