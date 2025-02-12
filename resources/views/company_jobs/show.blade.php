<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('company_jobs.index') }}" class="text-white hover:text-gray-400">
                {{ __('company_jobs.show.positions') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('company_jobs.show.position_details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('company_jobs.show.company') }}:</strong> {{ $companyJob->company->name }}</p>
                        <p><strong>{{ __('company_jobs.show.job_position') }}:</strong> {{ $companyJob->jobPosition->title }}</p>
                        <p><strong>{{ __('company_jobs.show.base_salary') }}:</strong> {{ $companyJob->base_salary }}</p>
                        <p><strong>{{ __('company_jobs.show.night_salary') }}:</strong> {{ $companyJob->night_salary }}</p>
                        <p><strong>{{ __('company_jobs.show.weekend_salary') }}:</strong> {{ $companyJob->weekend_salary }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>