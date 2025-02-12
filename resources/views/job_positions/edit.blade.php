<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('job_positions.index') }}" class="text-white hover:text-gray-400">
                {{ __('job_positions.edit.job_positions') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('job_positions.edit.edit_job_position') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('job_positions.update', $jobPosition->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="form-label">{{ __('job_positions.edit.title') }}</label>
                        <input type="text" name="title" id="title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                               @error('title') border-red-500 @enderror"
                               value="{{ old('title', $jobPosition->title) }}" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">{{ __('job_positions.edit.description') }}</label>
                        <textarea name="description" id="description"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                  @error('description') border-red-500 @enderror"
                                  rows="4">{{ old('description', $jobPosition->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('job_positions.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('job_positions.edit.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('job_positions.edit.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
