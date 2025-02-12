<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('current_student_payments.index.payments') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-gray-700 border border-gray-600 rounded-lg text-sm">
                            <thead>
                            <tr class="bg-gray-600 text-gray-200">
                                    <th class="px-3 py-2 border text-center">#</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.student') }}</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.bank_account') }}</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.owner_name') }}</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.period') }}</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.payment') }}</th>
                                    <th class="px-3 py-2 border">{{ __('current_student_payments.index.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student_payments as $student_payment)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $student_payment->student_name ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $student_payment->bank_account_number ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $student_payment->owner_name ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $student_payment->work_date }}</td>
                                        <td class="px-3 py-2 border">{{ $student_payment->total_salary }} Ft</td>
                                        <td class="px-3 py-2 border">
                                            @if ($student_payment->fulfilled == 0)
                                                <span class="text-red-500 font-semibold">{{ __('current_student_payments.index.pending') }}</span>
                                            @else
                                                <span class="text-green-500 font-semibold">{{ __('current_student_payments.index.fulfilled') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>