<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('companies.index.companies') }}
                </h2>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('companies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                    {{ __('companies.index.add_new_company') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-gray-700 border border-gray-300 rounded-lg text-sm">
                            <thead>
                                <tr class="bg-gray-600 text-gray-200">
                                    <th class="px-3 py-2 border text-center">{{ __('companies.index.id') }}</th>
                                    <th class="px-3 py-2 border">{{ __('companies.index.name') }}</th>
                                    <th class="px-3 py-2 border">{{ __('companies.index.email') }}</th>
                                    <th class="px-3 py-2 border">{{ __('companies.index.phone') }}</th>
                                    <th class="px-3 py-2 border">{{ __('companies.index.address') }}</th>
                                    <th class="px-3 py-2 border text-center">{{ __('companies.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $company->name }}</td>
                                        <td class="px-3 py-2 border">{{ $company->email }}</td>
                                        <td class="px-3 py-2 border">{{ $company->phone }}</td>
                                        <td class="px-3 py-2 border">{{ $company->address }}</td>
                                        <td class="px-3 py-2 border text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="{{ route('companies.show', $company->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white rounded action-button">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('companies.edit', $company->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white rounded action-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('{{ __('companies.index.confirm_delete') }}');" style="display:inline;">
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