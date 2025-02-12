<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('company_payments.index.payments') }}
                </h2>
            </div>

        <div class="col-md-6 text-right">
            <a href="{{ url('/export-company-payments') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                {{ __('company_payments.index.xml_download') }}
            </a>
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
                                    <th class="px-3 py-2 border">{{ __('company_payments.index.company') }}</th>
                                    <th class="px-3 py-2 border">{{ __('company_payments.index.period') }}</th>
                                    <th class="px-3 py-2 border">{{ __('company_payments.index.amount') }}</th>
                                    <th class="px-3 py-2 border">{{ __('company_payments.index.status') }}</th>
                                    <th class="px-3 py-2 border">{{ __('company_payments.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company_payments as $company_payment)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $company_payment->company_name ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $company_payment->work_date }}</td>
                                        <td class="px-3 py-2 border">{{ $company_payment->total_salary }} Ft</td>
                                        <td class="px-3 py-2 border">
                                            @if ($company_payment->fulfilled == 0)
                                                <span class="text-red-500 font-semibold">{{ __('company_payments.index.pending') }}</span>
                                            @else
                                                <span class="text-green-500 font-semibold">{{ __('company_payments.index.fulfilled') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 border">
                                            <div class="flex space-x-2">
                                                @if ($company_payment->fulfilled == 0)
                                                    <form action="{{ route('company_payments.change_paid', $company_payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white rounded action-button">
                                                            <i class="fas fa-money-bill-1"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('company_payments.change_not_paid', $company_payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded action-button">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('company_payments.pdf', $company_payment->id) }}">
                                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white rounded action-button">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </a>
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