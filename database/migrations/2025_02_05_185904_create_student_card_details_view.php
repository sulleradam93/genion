<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateStudentCardDetailsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $viewExists = DB::select("SELECT TABLE_NAME FROM information_schema.VIEWS WHERE TABLE_NAME = 'student_card_details'");

        if (empty($viewExists)) {
            DB::statement('
                CREATE VIEW student_card_details AS
                SELECT s.id AS student_id, s.name AS student_name, s.email, s.card_id, 
                       sc.owner_name, sc.bank_account_number
                FROM students s
                LEFT JOIN student_cards sc ON s.card_id = sc.id;
            ');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS student_card_details');
    }
}
