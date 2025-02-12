<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER delete_student_card
            AFTER DELETE ON students
            FOR EACH ROW
            BEGIN
                DELETE FROM student_cards WHERE id = OLD.card_id;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER delete_company_payments
            AFTER DELETE ON companies
            FOR EACH ROW
            BEGIN
                DELETE FROM company_payments WHERE company_id = OLD.id;
            END;
        ");
        

        DB::unprepared("
            CREATE TRIGGER delete_company_jobs
            AFTER DELETE ON companies
            FOR EACH ROW
            BEGIN
                DELETE FROM company_jobs WHERE company_id = OLD.id;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER delete_work_records_on_job_delete
            AFTER DELETE ON company_jobs
            FOR EACH ROW
            BEGIN
                DELETE FROM work_records WHERE company_job_id = OLD.id;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER delete_student_payments
            AFTER DELETE ON students
            FOR EACH ROW
            BEGIN
                DELETE FROM student_payments WHERE student_id = OLD.id;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER delete_work_records_on_student_delete
            AFTER DELETE ON students
            FOR EACH ROW
            BEGIN
                DELETE FROM work_records WHERE student_id = OLD.id;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER delete_company_jobs_on_job_position_delete
            AFTER DELETE ON job_positions
            FOR EACH ROW
            BEGIN
                DELETE FROM company_jobs WHERE job_id = OLD.id;
            END;
        ");
        
        DB::unprepared("
            CREATE TRIGGER delete_user_on_student_delete
            AFTER DELETE ON students
            FOR EACH ROW
            BEGIN
                DELETE FROM users WHERE id = OLD.user_id;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER delete_user_on_company_delete
            AFTER DELETE ON companies
            FOR EACH ROW
            BEGIN
                DELETE FROM users WHERE id = OLD.user_id;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS delete_student_card");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_company_jobs");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_work_records_on_job_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_work_records_on_student_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_company_jobs_on_job_position_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_company_payments");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_student_payments");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_user_on_student_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS delete_user_on_company_delete");
    }

};
