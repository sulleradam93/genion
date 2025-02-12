<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('work_records.index.title') }}
                </h2>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('work_records.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                    {{ __('work_records.index.add_new') }}
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
                                    <th class="px-3 py-2 border text-center">{{ __('work_records.index.id') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.student') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.company') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.job') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.work_start') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.work_end') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.salary') }}</th>
                                    <th class="px-3 py-2 border">{{ __('work_records.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workRecords as $record)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $record->student_name ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $record->company_name ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $record->job_title ?? '-' }}</td>
                                        <td class="px-3 py-2 border">{{ $record->work_date_begin }}</td>
                                        <td class="px-3 py-2 border">{{ $record->work_date_end }}</td>
                                        <td class="px-3 py-2 border">{{ $record->total_salary }} Ft</td>                                        
                                        <td class="px-3 py-2 border">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('work_records.show', $record->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white rounded action-button">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('work_records.edit', $record->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white rounded action-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('work_records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('{{ __('work_records.index.delete_confirmation') }}');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded action-button">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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