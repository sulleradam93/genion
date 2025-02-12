<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('students.index') }}" class="text-white hover:text-gray-400">
                {{ __('students.create.title') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('students.create.add') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('students.create.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('students.create.email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('students.create.phone') }}</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">{{ __('students.create.birth_date') }}</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">{{ __('students.create.gender') }}</label>
                            <select name="gender" id="gender" 
                                class="form-control appearance-none bg-white border-gray-500 text-gray-900 text-base p-2 rounded-none shadow-none focus:outline-none focus:border-gray-600 focus:ring-0">
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('students.create.male') }}</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('students.create.female') }}</option>
                            </select>
                            @error('gender')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('students.create.address') }}</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                        @error('address')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">{{ __('students.create.cv') }}</label>
                        <input type="file" name="cv" id="cv" class="form-control">
                        @error('cv')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <b class="block text-lg font-semibold text-gray-700 mt-10 mb-2">{{ __('students.create.bank_card_details') }}</b>

                    <div class="mb-3">
                        <label for="owner_name" class="form-label">{{ __('students.create.card_owner') }}</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ old('owner_name') }}">
                        @error('owner_name')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bank_account_number" class="form-label">{{ __('students.create.bank_account_number') }}</label>
                        <input type="text" name="bank_account_number" id="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}">
                        @error('bank_account_number')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('students.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('students.create.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('students.create.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>