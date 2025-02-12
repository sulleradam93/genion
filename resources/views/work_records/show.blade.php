<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('work_records.index') }}" class="text-white hover:text-gray-400">
                {{ __('work_records.details.title') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('work_records.details.details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">

                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('work_records.details.student') }}:</strong> {{ $workRecord->student_name ?? '-' }}</p>
                        <p><strong>{{ __('work_records.details.company') }}:</strong> {{ $workRecord->company_name ?? '-' }}</p>
                        <p><strong>{{ __('work_records.details.job') }}:</strong> {{ $workRecord->job_title ?? '-' }}</p>
                        <p><strong>{{ __('work_records.details.work_start') }}:</strong> {{ $workRecord->work_date_begin ?? '-' }}</p>
                        <p><strong>{{ __('work_records.details.work_end') }}:</strong> {{ $workRecord->work_date_end ?? '-' }}</p>
                        
                        <p><strong>{{ __('work_records.details.calculation') }}:</strong></p>
                        @php
                            $calculated = json_decode($workRecord->calculated, true);
                        @endphp

                        <div class="bg-gray-700 p-4 rounded-md text-white">
                            @if ($calculated['base_hours'] > 0)
                                <p>{{ __('work_records.details.base_salary') }}: {{ $calculated['base_hours'] }} x {{ $calculated['base_salary'] }} Ft</p>
                            @endif

                            @if ($calculated['night_hours'] > 0)
                                <p>{{ __('work_records.details.night_salary') }}: {{ $calculated['night_hours'] }} x {{ $calculated['night_salary'] }} Ft</p>
                            @endif

                            @if ($calculated['weekend_hours'] > 0)
                                <p>{{ __('work_records.details.weekend_salary') }}: {{ $calculated['weekend_hours'] }} x {{ $calculated['weekend_salary'] }} Ft</p>
                            @endif
                        </div>

                        <p class="text-lg font-semibold mt-4"><strong>{{ __('work_records.details.total_salary') }}:</strong> {{ $workRecord->total_salary }} Ft</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>