<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('students.index.title') }}
                </h2>
            </div>

            <div class="col-md-6 text-right flex">
                <div class="relative max-w-[240px] ml-auto">
                    <input
                        type="text"
                        id="search-input"
                        placeholder="{{ __('students.index.search_placeholder') }}"
                        class="border border-gray-300 rounded text-sm py-2 px-6 w-full pl-10"
                    />
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <a href="{{ route('students.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-xs py-2 px-4 rounded ml-4 flex items-center">
                    {{ __('students.index.add_student') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table id="students-table" class="min-w-full text-gray-700 border border-gray-600 rounded-lg text-sm">
                            <thead>
                                <tr class="bg-gray-600 text-gray-200">
                                    <th class="px-3 py-2 min-w-[100px] border text-center">
                                        <a href="{{ route('students.index', ['sort_field' => 'id', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                            {{ __('students.index.id') }}
                                            @if ($sortField == 'id')
                                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'desc' ? 'down-alt' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-3 py-2 border">
                                        <a href="{{ route('students.index', ['sort_field' => 'name', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                            {{ __('students.index.name') }}
                                            @if ($sortField == 'name')
                                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'desc' ? 'down-alt' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-3 py-2 border">
                                        <a href="{{ route('students.index', ['sort_field' => 'email', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                            {{ __('students.index.email') }}
                                            @if ($sortField == 'email')
                                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'desc' ? 'down-alt' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-3 py-2 border">{{ __('students.index.phone') }}</th>
                                    <th class="px-3 py-2 border">{{ __('students.index.address') }}</th>
                                    <th class="px-3 py-2 border">{{ __('students.index.gender') }}</th>
                                    <th class="px-3 py-2 border">{{ __('students.index.cv') }}</th>
                                    <th class="px-3 py-2 border">{{ __('students.index.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="border-t border-gray-500 hover:bg-gray-200 hover:text-gray-700 transition">
                                        <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2 border">{{ $student->name }}</td>
                                        <td class="px-3 py-2 border">{{ $student->email }}</td>
                                        <td class="px-3 py-2 border">{{ $student->phone }}</td>
                                        <td class="px-3 py-2 border">{{ $student->address }}</td>
                                        <td class="px-3 py-2 border">{{ $student->gender == "male" ? __('students.index.male') : __('students.index.female') }}</td>
                                        <td class="px-3 py-2 border text-center">
                                            @if ($student->cv)
                                                <a href="{{ asset('downloads/cv/' . $student->cv) }}" target="_blank" class="text-blue-500 hover:underline">
                                                    <i class="fas fa-file-pdf text-red-500"></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 border">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('students.show', $student->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white rounded action-button">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('students.edit', $student->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white rounded action-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ __('students.index.confirm_delete') }}');" style="display:inline;">
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

    <!-- JQuery Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#search-input').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#students-table tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</x-app-layout>