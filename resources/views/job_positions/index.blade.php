<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('job_positions.index.job_positions') }}
                </h2>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('job_positions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                    {{ __('job_positions.index.add_new') }}
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
                                    <th class="px-3 py-2 border text-center">#</th>
                                    <th class="px-3 py-2 border">{{ __('job_positions.index.job_position') }}</th>
                                    <th class="px-3 py-2 border w-3/5">{{ __('job_positions.index.description') }}</th>
                                    <th class="px-3 py-2 border text-center">{{ __('job_positions.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobPositions as $position)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $position->title }}</td>
                                        <td class="px-3 py-2 border">{{ $position->description }}</td>
                                        <td class="px-3 py-2 border text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="{{ route('job_positions.show', $position->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white rounded action-button">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('job_positions.edit', $position->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white rounded action-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('job_positions.destroy', $position->id) }}" method="POST" onsubmit="return confirm('{{ __('job_positions.index.confirm_delete') }}');" style="display:inline;">
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