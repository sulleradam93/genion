<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('managers.index.title') }}
                </h2>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('managers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded">
                    {{ __('managers.index.add_new') }}
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
                                    <th class="px-3 py-2 border text-center">{{ __('managers.index.id') }}</th>
                                    <th class="px-3 py-2 border">{{ __('managers.index.name') }}</th>
                                    <th class="px-3 py-2 border">{{ __('managers.index.email') }}</th>
                                    <th class="px-3 py-2 border">{{ __('managers.index.phone') }}</th>
                                    <th class="px-3 py-2 border">{{ __('managers.index.role') }}</th>
                                    <th class="px-3 py-2 border text-center">{{ __('managers.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $user->name }}</td>
                                        <td class="px-3 py-2 border">{{ $user->email }}</td>
                                        <td class="px-3 py-2 border">{{ $user->phone }}</td>
                                        <td class="px-3 py-2 border">{{ $user->role }}</td>
                                        <td class="px-3 py-2 border text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="{{ route('managers.show', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white rounded action-button">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('managers.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white rounded action-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('managers.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('managers.index.confirm_delete') }}');" style="display:inline;">
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