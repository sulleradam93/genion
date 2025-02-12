<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('work_records.index') }}" class="text-white hover:text-gray-400">
                {{ __('work_records.create.title') }}
            </a>
            <span class="mx-2"> &gt; </span>
            {{ __('work_records.create.add_work_record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('work_records.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                    <input type="hidden" name="company_id" id="company_id" value="{{ old('company_id') }}">
                    <input type="hidden" name="job_id" id="job_id" value="{{ old('job_id') }}">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="student" class="form-label">{{ __('work_records.create.student_select') }}</label>
                            <div class="autocomplete-group">
                                <input type="text" id="student" class="autocomplete-input form-control"
                                    autocomplete="off"
                                    value="{{ old('student_name') }}"
                                    data-id="{{ old('student_id') }}">
                                <div id="student-list" class="list-container">
                                    @foreach ($students as $student)
                                        <div class="list-item" data-id="{{ $student->id }}">{{ $student->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="company" class="form-label">{{ __('work_records.create.company_select') }}</label>
                            <div class="autocomplete-group">
                                <input type="text" id="company" class="autocomplete-input form-control"
                                    autocomplete="off"
                                    value="{{ old('company_name') }}"
                                    data-id="{{ old('company_id') }}">
                                <div id="company-list" class="list-container">
                                    @foreach ($companies as $company)
                                        <div class="list-item" data-id="{{ $company->id }}">{{ $company->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="job" class="form-label">{{ __('work_records.create.job_select') }}</label>
                            <div class="autocomplete-group">
                                <input type="text" id="job" class="autocomplete-input form-control"
                                    autocomplete="off"
                                    value="{{ old('job_title') }}"
                                    data-id="{{ old('job_id') }}">
                                <div id="job-list" class="list-container">
                                    @foreach ($jobPositions as $job)
                                        <div class="list-item" data-id="{{ $job->id }}">{{ $job->title }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="work_date_begin" class="form-label">{{ __('work_records.create.work_date_begin') }}</label>
                            <input id="work_date_begin" class="form-control" type="datetime-local" name="work_date_begin" 
                                value="{{ date('Y-m-d\TH:i', strtotime(old('work_date_begin'))) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="work_date_end" class="form-label">{{ __('work_records.create.work_date_end') }}</label>
                            <input id="work_date_end" class="form-control" type="datetime-local" name="work_date_end" 
                                value="{{ date('Y-m-d\TH:i', strtotime(old('work_date_end'))) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="base_hours" class="form-label">{{ __('work_records.create.base_hours') }}</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="base_hours" class="form-control" type="number" name="base_hours" value="{{ old('base_hours') }}" required />
                                </div>
                                <div class="col-md-8">
                                    <input id="base_salary" class="form-control" type="number" name="base_salary" value="{{ old('base_salary') }}" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="night_hours" class="form-label">{{ __('work_records.create.night_hours') }}</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="night_hours" class="form-control" type="number" name="night_hours" value="{{ old('night_hours') }}" required />
                                </div>
                                <div class="col-md-8">
                                    <input id="night_salary" class="form-control" type="number" name="night_salary" value="{{ old('night_salary') }}" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="weekend_hours" class="form-label">{{ __('work_records.create.weekend_hours') }}</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="weekend_hours" class="form-control" type="number" name="weekend_hours" value="{{ old('weekend_hours') }}" required />
                                </div>
                                <div class="col-md-8">
                                    <input id="weekend_salary" class="form-control" type="number" name="weekend_salary" value="{{ old('weekend_salary') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="comment" class="form-label">{{ __('work_records.create.comment') }}</label>
                            <textarea id="comment" rows="5" class="form-control border-gray-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-none shadow-sm" name="comment">{{ old('comment') }}</textarea>
                        </div>

                        <div class="col-md-5">
                            <label for="total_salary" class="form-label">{{ __('work_records.create.total_salary') }}</label>
                            <input id="total_salary" class="form-control" type="number" name="total_salary" value="{{ old('total_salary') }}" required />
                            <span class="danger-message mt-3">{{ __('work_records.create.discrepancy_warning') }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('work_records.index') }}" class="ml-4 px-4 py-2 text-gray-600 border border-gray-300 border-2 rounded-md focus:outline-none no-underline">
                            {{ __('work_records.create.cancel') }}
                        </a>

                        <button class="btn btn-primary ml-4 px-4 py-2">
                            {{ __('work_records.create.save') }}
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

    $('#student').on('keyup', function () {
        filterList($(this), $('#student-list'));
    });

    $('#student-list').on('click', '.list-item', function () {
        var selectedStudent = $(this).text();
        var studentId = $(this).data('id');

        $('#student').val(selectedStudent);
        $('#student_id').val(studentId);
        $('#student-list').hide();
    });

    $('#company').on('keyup', function () {
        filterList($(this), $('#company-list'));
    });

    $('#company-list').on('click', '.list-item', function () {
        var selectedCompany = $(this).text();
        var company_id = parseInt($(this).data('id'));
        var job_id = parseInt($('#job_id').val());

        $('#company').val(selectedCompany);
        $('#company_id').val(company_id);
        $('#company-list').hide();

        $('#job-list').empty();

        $.ajax({
            url: '/api/job-positions/' + company_id + '/related',
            method: 'GET',
            success: function (data) {
                var jobList = $('#job-list');
                jobList.empty();

                var jobFound = false;

                if (data.length > 0) {
                    
                    data.forEach(function (job) {
                        if (job && job.title) {
                            jobList.append('<div class="list-item" data-id="' + job.id + '">' + job.title + '</div>');

                            if (job_id === job.id) {
                                jobFound = true;
                            }
                        }
                    });

                    if (!jobFound) {
                        $('#job_id').val('');
                        $('#job').val('');

                        var firstJob = data[0];
                        $('#job_id').val(firstJob.id);
                        $('#job').val(firstJob.title);
                    }
                } else {
                    jobList.append('<div class="list-item">Nincsenek elérhető munkakörök</div>');
                }

                job_id = parseInt($('#job_id').val());

                if (typeof company_id === 'number' && typeof job_id === 'number') {
                    fetchHourlySalaries(company_id, job_id);
                }

                jobList.hide();
            },
            error: function () {
                $('#job-list').empty().append('<div class="list-item">Hiba történt</div>');
            }
        });
    });

    function fetchHourlySalaries(company_id, job_id) {
        $.ajax({
            url: '/api/hourlysalaries/' + company_id + '/' + job_id, 
            method: 'GET',
            success: function (data) {
                if (data) {
                    var baseSalary = data.base_salary || 'N/A';
                    var nightSalary = data.night_salary || 'N/A';
                    var weekendSalary = data.weekend_salary || 'N/A';

                    console.log('Base Hourly Salary:', baseSalary);
                    console.log('Night Hourly Salary:', nightSalary);
                    console.log('Weekend Hourly Salary:', weekendSalary);

                    $('#base_hours').val("8");
                    $('#base_salary').val(baseSalary);
                    $('#night_hours').val("0");
                    $('#night_salary').val(nightSalary);
                    $('#weekend_hours').val("0");
                    $('#weekend_salary').val(weekendSalary);
                    calculateTotalSalary(1);
                }
            }
        });
    }

    $('#job').on('keyup', function () {
        filterList($(this), $('#job-list'));
    });

    $('#job-list').on('click', '.list-item', function () {
        var selectedJob = $(this).text();
        var job_id = parseInt($(this).data('id'));
        var company_id = parseInt($('#company_id').val());

        $('#job').val(selectedJob);
        $('#job_id').val(job_id);
        $('#job-list').hide();
        
        if (typeof company_id === 'number' && typeof job_id === 'number') {
            fetchHourlySalaries(company_id, job_id);
        }
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.autocomplete-input, .list-container').length) {
            $('.list-container').hide();
        }
    });

    function setDefaultDates() {
        let workDateBegin = $('#work_date_begin').val();
        let workDateEnd = $('#work_date_end').val();

        let now = new Date();
        let today = now.toISOString().split('T')[0];

        if (new Date(workDateBegin).getFullYear() === 1970 || !workDateBegin) {
            $('#work_date_begin').val(today + 'T06:00');
        }

        if (new Date(workDateEnd).getFullYear() === 1970 || !workDateEnd) {
            $('#work_date_end').val(today + 'T14:00');
        }
    }

    setDefaultDates();

    function updateEndDate() {
        let startDateValue = $('#work_date_begin').val(); 
        if (startDateValue) {
            
            let [date, time] = startDateValue.split("T");
            let [hours, minutes] = time.split(":").map(Number);

            let startDate = new Date(`${date}T${time}Z`);

            startDate.setUTCHours(startDate.getUTCHours() + 8);

            let formattedEndDate = startDate.toISOString().slice(0, 16);

            $('#work_date_end').val(formattedEndDate);
        }
    }

    $('#work_date_begin').on('change', updateEndDate);

    $('#base_hours, #base_salary, #night_hours, #night_salary, #weekend_hours, #weekend_salary').on('input', function() {
        calculateTotalSalary(1);
    });

    $('#total_salary').on('input', function() {
        calculateTotalSalary(0);
    });

    function calculateTotalSalary(set_total) {
        var base_hours = parseInt($('#base_hours').val()) || 0;
        var base_salary = parseInt($('#base_salary').val()) || 0;
        var night_hours = parseInt($('#night_hours').val()) || 0;
        var night_salary = parseInt($('#night_salary').val()) || 0;
        var weekend_hours = parseInt($('#weekend_hours').val()) || 0;
        var weekend_salary = parseInt($('#weekend_salary').val()) || 0;

        var total_salary_calculated = base_hours * base_salary + night_hours * night_salary + weekend_hours * weekend_salary;

        if(set_total){
            $('#total_salary').val(total_salary_calculated);
        }

        if (total_salary_calculated !== parseInt($('#total_salary').val())) {
            $('#total_salary').addClass('danger');
        } else {
            $('#total_salary').removeClass('danger');
        }
    }

    function prefillAutoCompleteFields() {
        
        var studentId = $('#student_id').val();
        if (studentId) {
            var studentName = $('#student').val();

            $('#student-list .list-item').each(function () {
                if ($(this).data('id') == studentId) {
                    $('#student').val($(this).text());
                    $('#student_id').val(studentId);
                    return false;
                }
            });
        }

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
    }

    prefillAutoCompleteFields();
});
</script>