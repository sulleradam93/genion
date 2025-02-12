<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        DB::statement("SET GLOBAL event_scheduler = ON");

        //STARTS CONCAT(DATE_FORMAT(CURRENT_DAY, '%Y-%m-05'), ' 00:00:00'),
        DB::statement("
            CREATE EVENT IF NOT EXISTS monthly_salary_summary
            ON SCHEDULE EVERY 1 MONTH
            STARTS NOW() + INTERVAL 1 MINUTE
            DO BEGIN
                INSERT INTO student_payments (student_id, total_salary, fulfilled, work_date, created_at)
                SELECT 
                    wr.student_id,
                    SUM(wr.total_salary) AS total_salary,
                    0 AS fulfilled,
                    DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m') AS work_date,
                    NOW() AS created_at
                FROM work_records wr
                WHERE wr.student_invoice_id = 0
                    AND (YEAR(wr.work_date_begin) < YEAR(NOW()) 
                        OR (YEAR(wr.work_date_begin) = YEAR(NOW()) AND MONTH(wr.work_date_begin) < MONTH(NOW())))
                GROUP BY wr.student_id;

                UPDATE work_records wr
                JOIN student_payments p ON wr.student_id = p.student_id
                SET wr.student_invoice_id = p.id
                WHERE wr.student_invoice_id = 0 
                    AND p.created_at = CURDATE()
                    AND (YEAR(wr.work_date_begin) < YEAR(NOW()) 
                        OR (YEAR(wr.work_date_begin) = YEAR(NOW()) AND MONTH(wr.work_date_begin) < MONTH(NOW())));

                INSERT INTO company_payments (company_id, total_salary, fulfilled, work_date, created_at)
                SELECT 
                    cj.company_id,
                    SUM(wr.total_salary) AS total_salary,
                    0 AS fulfilled,
                    DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m') AS work_date,
                    NOW() AS created_at
                FROM work_records wr
                JOIN company_jobs cj ON wr.company_job_id = cj.id
                WHERE wr.company_invoice_id = 0
                    AND (YEAR(wr.work_date_begin) < YEAR(NOW()) 
                        OR (YEAR(wr.work_date_begin) = YEAR(NOW()) AND MONTH(wr.work_date_begin) < MONTH(NOW())))
                GROUP BY cj.company_id;

                UPDATE work_records wr
                JOIN company_jobs cj ON wr.company_job_id = cj.id
                JOIN company_payments p ON cj.company_id = p.company_id
                SET wr.company_invoice_id = p.id
                WHERE wr.company_invoice_id = 0
                    AND p.created_at = CURDATE()
                    AND (YEAR(wr.work_date_begin) < YEAR(NOW()) 
                        OR (YEAR(wr.work_date_begin) = YEAR(NOW()) AND MONTH(wr.work_date_begin) < MONTH(NOW())));
            END
        ");

    }

    public function down(): void
    {
        DB::statement("DROP EVENT IF EXISTS monthly_salary_summary");
    }
};
