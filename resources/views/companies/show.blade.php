<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('companies.index') }}" class="text-white hover:text-gray-400">
                {{ __('companies.show.companies') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('companies.show.company_info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('companies.show.company') }}:</strong> {{ $company->name }}</p>
                        <p><strong>{{ __('companies.show.email') }}:</strong> {{ $company->email }}</p>
                        <p><strong>{{ __('companies.show.phone') }}:</strong> {{ $company->phone }}</p>
                        <p><strong>{{ __('companies.show.address') }}:</strong> {{ $company->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>