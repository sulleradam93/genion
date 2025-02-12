<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('company_job_id');
            $table->datetime('work_date_begin');
            $table->datetime('work_date_end');
            $table->integer('total_salary');
            $table->string('calculated');
            $table->string('comment')->nullable();
            $table->integer('student_invoice_id')->default(0);
            $table->integer('company_invoice_id')->default(0);
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('company_job_id')->references('id')->on('company_jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_records');
    }
};
