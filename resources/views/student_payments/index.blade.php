<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('student_payments.index.payments') }}
                </h2>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ url('/export-student-payments') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                    {{ __('student_payments.index.xls_download') }}
                </a>
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
                                    <th class="px-3 py-2 border text-center">{{ __('#') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.student') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.company') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.owner_name') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.period') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.status') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.payment') }}</th>
                                    <th class="px-3 py-2 border">{{ __('student_payments.index.actions') }}</th>
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
                                                <span class="text-red-500 font-semibold">{{ __('student_payments.index.pending') }}</span>
                                            @else
                                                <span class="text-green-500 font-semibold">{{ __('student_payments.index.fulfilled') }}</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-3 py-2 border">
                                            <div class="flex space-x-2">
                                            @if ($student_payment->fulfilled == 0)
                                                <form action="{{ route('student_payments.change_paid', $student_payment->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white rounded action-button">
                                                        <i class="fas fa-money-bill-1"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('student_payments.change_not_paid', $student_payment->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded action-button">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            </div>
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