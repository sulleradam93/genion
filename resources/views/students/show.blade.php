<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('students.index') }}" class="text-white hover:text-gray-400">
                {{ __('students.show.students') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('students.show.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="grid gap-3 text-gray-700">
                        <p><strong>{{ __('students.show.name') }}:</strong> {{ $student->name }}</p>
                        <p><strong>{{ __('students.show.email') }}:</strong> {{ $student->email }}</p>
                        <p><strong>{{ __('students.show.phone') }}:</strong> {{ $student->phone }}</p>
                        <p><strong>{{ __('students.show.birth_date') }}:</strong> {{ $student->birth_date }}</p>
                        <p><strong>{{ __('students.show.address') }}:</strong> {{ $student->address ?? 'N/A' }}</p>
                        <p><strong>{{ __('students.show.gender') }}:</strong> {{ ucfirst($student->gender) ?? 'N/A' }}</p>
                        <p><strong>{{ __('students.show.cv') }}:</strong> 
                            @if ($student->cv)
                                <a href="{{ asset('downloads/cv/' . $student->cv) }}" target="_blank" class="text-blue-500 underline">{{ __('students.show.view_cv') }}</a>
                            @else
                                {{ __('students.show.no_cv_uploaded') }}
                            @endif
                        </p>
                    </div>

                    @if ($student->card && $student->card->owner_name && $student->card->bank_account_number)
                        <div class="mt-8 mb-2 text-gray-700">
                            <strong>{{ __('students.show.bank_card_details') }}:</strong>
                        </div>
                        <div class="grid gap-3 text-gray-700">
                            <p><strong>{{ __('students.show.card_owner') }}:</strong> {{ $student->card->owner_name }}</p>
                            <p><strong>{{ __('students.show.bank_account_number') }}:</strong> {{ $student->card->bank_account_number }}</p>
                        </div>
                    @else
                        <p><strong>{{ __('students.show.bank_card_details') }}:</strong> {{ __('students.show.no_bank_info') }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>