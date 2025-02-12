<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('students.index') }}" class="text-white hover:text-gray-400">
                {{ __('students.edit.students') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('students.edit.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('students.edit.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('students.edit.email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('students.edit.phone') }}</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">{{ __('students.edit.birth_date') }}</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $student->birth_date) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">{{ __('students.edit.gender') }}</label>
                            <select name="gender" id="gender" 
                                class="form-control appearance-none bg-white border-gray-500 text-gray-900 text-base p-2 rounded-none shadow-none focus:outline-none focus:border-gray-600 focus:ring-0">
                                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>{{ __('students.edit.male') }}</option>
                                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>{{ __('students.edit.female') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('students.edit.address') }}</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $student->address) }}">
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">{{ __('students.edit.cv') }}</label>
                        <input type="file" name="cv" id="cv" class="form-control">
                        @if ($student->cv)
                            <a href="{{ asset('downloads/cv/' . $student->cv) }}" target="_blank" class="text-blue-500 underline">{{ __('students.edit.view_cv') }}</a>
                        @endif
                    </div>

                    <b class="block text-lg font-semibold text-gray-700 mt-10 mb-2">{{ __('students.edit.bank_card_details') }}</b>

                    <div class="mb-3">
                        <label for="owner_name" class="form-label">{{ __('students.edit.card_owner') }}</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ old('owner_name', optional($student->card)->owner_name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="bank_account_number" class="form-label">{{ __('students.edit.bank_account_number') }}</label>
                        <input type="text" name="bank_account_number" id="bank_account_number" class="form-control" value="{{ old('bank_account_number', optional($student->card)->bank_account_number) }}">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('students.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('students.edit.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('students.edit.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>