<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('company_jobs.index') }}" class="text-white hover:text-gray-400">
                {{ __('company_jobs.create.positions') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('company_jobs.create.add_position') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('company_jobs.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="company_id" id="company_id" value="{{ old('company_id') }}">
                    <input type="hidden" name="job_id" id="job_id" value="{{ old('job_id') }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="company" class="form-label">{{ __('company_jobs.create.select_company') }}</label>
                            <div class="autocomplete-group">
                                <input type="text" id="company" class="autocomplete-input form-control @error('company_id') is-invalid @enderror"
                                    autocomplete="off"
                                    value="{{ old('company_name') }}"
                                    data-id="{{ old('company_id') }}">
                                <div id="company-list" class="list-container">
                                    @foreach ($companies as $company)
                                        <div class="list-item" data-id="{{ $company->id }}">{{ $company->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                            @error('company_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="job" class="form-label">{{ __('company_jobs.create.select_job') }}</label>
                            <div class="autocomplete-group">
                                <input type="text" id="job" class="autocomplete-input form-control @error('job_id') is-invalid @enderror"
                                    autocomplete="off"
                                    value="{{ old('job_title') }}"
                                    data-id="{{ old('job_id') }}">
                                <div id="job-list" class="list-container">
                                    @foreach ($jobPositions as $job)
                                        <div class="list-item" data-id="{{ $job->id }}">{{ $job->title }}</div>
                                    @endforeach
                                </div>
                            </div>
                            @error('job_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="base_salary" class="form-label">{{ __('company_jobs.create.base_salary') }}</label>
                            <input type="number" name="base_salary" id="base_salary" class="form-control @error('base_salary') is-invalid @enderror" value="{{ old('base_salary') }}" required>
                            @error('base_salary')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="night_salary" class="form-label">{{ __('company_jobs.create.night_salary') }}</label>
                            <input type="number" name="night_salary" id="night_salary" class="form-control @error('night_salary') is-invalid @enderror" value="{{ old('night_salary') }}">
                            @error('night_salary')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="weekend_salary" class="form-label">{{ __('company_jobs.create.weekend_salary') }}</label>
                            <input type="number" name="weekend_salary" id="weekend_salary" class="form-control @error('weekend_salary') is-invalid @enderror" value="{{ old('weekend_salary') }}">
                            @error('weekend_salary')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('company_jobs.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('company_jobs.create.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('company_jobs.create.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function () {
    
    function filterList(input, listContainer) {
        var query = input.val().toLowerCase();
        listContainer.children('.list-item').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(query));
        });
    }

    $('.autocomplete-input').on('focus', function () {
        var listContainer = $(this).next('.list-container');
        $('.list-container').hide();
        listContainer.show();
    });

    $('#company').on('keyup', function () {
        filterList($(this), $('#company-list'));
    });

    $('#company-list').on('click', '.list-item', function () {
        var selectedCompany = $(this).text();
        var companyId = $(this).data('id');

        $('#company').val(selectedCompany);
        $('#company_id').val(companyId);
        $('#company-list').hide();

        $('#job').val('');
        $('#job_id').val('');
        $('#job-list').empty();

        $.ajax({
            url: '/api/job-positions/' + companyId + '/unrelated',
            method: 'GET',
            success: function (data) {
                var jobList = $('#job-list');
                jobList.empty();

                if (data.length > 0) {
                    data.forEach(function (job) {
                        if (job && job.title) {
                            jobList.append('<div class="list-item" data-id="' + job.id + '">' + job.title + '</div>');
                        }
                    });

                    var firstJob = jobList.find('.list-item').first();
                    $('#job').val(firstJob.text());
                    $('#job_id').val(firstJob.data('id'));

                    jobList.hide();
                } else {
                    jobList.append('<div class="list-item">Nincsenek elérhető munkakörök</div>');
                }
            },
            error: function () {
                $('#job-list').empty().append('<div class="list-item">Hiba történt</div>');
            }
        });

    });

    $('#job').on('keyup', function () {
        filterList($(this), $('#job-list'));
    });

    $('#job-list').on('click', '.list-item', function () {
        var selectedJob = $(this).text();
        var jobId = $(this).data('id');

        $('#job').val(selectedJob);
        $('#job_id').val(jobId);
        $('#job-list').hide();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.autocomplete-input, .list-container').length) {
            $('.list-container').hide();
        }
    });

    $('#base_hours').on('keyup', function () {
        var baseValue = $(this).val();
        $('#night_hours, #weekend_hours').val(baseValue);
    });

    var companyId = $('#company_id').val();
    if (companyId) {
        var companyName = $('#company').val();

        $('#company-list .list-item').each(function () {
            if ($(this).data('id') == companyId) {
                $('#company').val($(this).text());
                $('#company_id').val(companyId);
                return false;
            }
        });
    }

    var jobId = $('#job_id').val();
    if (jobId) {
        var jobTitle = $('#job').val();

        $('#job-list .list-item').each(function () {
            if ($(this).data('id') == jobId) {
                $('#job').val($(this).text());
                $('#job_id').val(jobId);
                return false;
            }
        });
    }
});
</script>