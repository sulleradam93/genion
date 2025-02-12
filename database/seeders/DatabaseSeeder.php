<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use App\Models\WorkRecord;
use App\Models\JobPosition;
use App\Models\StudentCard;
use App\Services\AppService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use DB;

class DatabaseSeeder extends Seeder
{
    protected $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $faker = Faker::create('hu_HU');

        $generatePhoneNumber = function () use ($faker) {
            $prefix = '+36';
            $servicer = $faker->randomElement([20, 30, 70]);
            $number = str_pad($faker->numberBetween(1000000, 9999999), 7, '0', STR_PAD_LEFT);
            return $prefix . $servicer . $number;
        };

        $default_users = [
            [
                'name' => 'Suller Ádám',
                'email' => 'sulleradam93@gmail.com',
                'password' => Hash::make('pwasdqwe123'),
                'phone' => $generatePhoneNumber(),
                'role' => 'admin'
            ],
            [
                'name' => 'Forgács István',
                'email' => 'istvan.forgacs@genion.hu',
                'password' => Hash::make('gj5F_2fgOz93frexbx'),
                'phone' => $generatePhoneNumber(),
                'role' => 'admin'
            ],
            [
                'name' => 'Kovács Béla',
                'email' => 'kovacsbela@gmail.com',
                'password' => Hash::make('pwasdqwe123'),
                'phone' => $generatePhoneNumber(),
                'role' => 'manager'
            ],
            [
                'name' => 'Szilágyi Zoltán',
                'email' => 'szilagyizoltan@gmail.com',
                'password' => Hash::make('pwasdqwe123'),
                'phone' => $generatePhoneNumber(),
                'role' => 'manager'
            ],
            [
                'name' => 'Jácint Rebeka',
                'email' => 'jacintrebeka@gmail.com',
                'password' => Hash::make('pwasdqwe123'),
                'phone' => $generatePhoneNumber(),
                'role' => 'manager'
            ]
        ];

        $usedNames = [];

        foreach ($default_users as $user) {
            User::create($user);
            $usedNames[] = $user['name'];
        }

        /* ******************************************* */

        $students = [];

        $student_test_name = 'Teszt Elek';
        $student_test_email = 'student-teszt-elek@testmail.com';

        $test_student = User::create([
            'name' => $student_test_name,
            'email' => $student_test_email,
            'password' => bcrypt('ac4Mq_lc93jG2gldR8'),
            'phone' => $generatePhoneNumber(),
            'role' => 'student'
        ]);
        
        $card = StudentCard::create([
            'owner_name' => $student_test_name,
            'bank_account_number' => $faker->bankAccountNumber,
        ]);
        
        $student = Student::where('email', $student_test_email)->first();
        
        if ($student) {
            $student->user_id = $test_student->id;
            $student->save();
        } else {
            $student = Student::create([
                'user_id' => $test_student->id,
                'card_id' => $card->id,
                'name' => $student_test_name,
                'email' => $student_test_email,
                'phone' => $generatePhoneNumber(),
                'address' => $faker->address,
                'gender' => 'male',
                'birth_date' => $faker->dateTimeBetween('2000-01-01', '2005-12-31')->format('Y-m-d'),
                'cv' => null,
            ]);
        }

        $usedNames[] = $student_test_name;

        $students[] = $student;
        
        /* ******************************************* */

        foreach (range(1, 100) as $index) {
            $gender = $faker->randomElement(['male', 'female']);
            
            $firstName = $gender == 'male' ? $faker->firstName('male') : $faker->firstName('female');
            do {
                $name = $faker->lastName . ' ' . $firstName;
            } while (in_array($name, $usedNames));
        
            $usedNames[] = $name;
        
            $email = $faker->unique()->email;
        
            $card = StudentCard::create([
                'owner_name' => $name,
                'bank_account_number' => $faker->bankAccountNumber
            ]);
        
            $student = Student::create([
                'card_id' => $card->id,
                'name' => $name,
                'email' => $email,
                'phone' => $generatePhoneNumber(),
                'address' => $faker->address,
                'gender' => $gender,
                'birth_date' => $faker->dateTimeBetween('2000-01-01', '2005-12-31')->format('Y-m-d'),
                'cv' => NULL,
            ]);
        
            $students[] = $student;
        }
        

        /* ******************************************* */

        $companies = [];

        $company_test_name = 'Teszt Kft.';
        $company_test_email = 'company-teszt-kft@testmail.com';

        $test_company = User::create([
            'name' => $company_test_name,
            'email' => $company_test_email,
            'password' => bcrypt('g6Htr7Ja9_v1kddg2'),
            'phone' => $generatePhoneNumber(),
            'role' => 'company'
        ]);
                
        $company = Company::where('email', $company_test_email)->first();
        
        if ($company) {
            $company->user_id = $test_company->id;
            $company->save();
        } else {
            $company = Company::create([
                'user_id' => $test_company->id,
                'name' => $company_test_name,
                'email' => $email,
                'phone' => $generatePhoneNumber(),
                'address' => $faker->address,
            ]);
        }

        $usedNames[] = $company_test_name;

        $companies[] = $company;

        $companySuffixes = [
            'Kft.',
            'Zrt.',
            'Nyrt.',
            'Bt.',
            'Kkt.',
            'Nonprofit Kft.'
        ];

        foreach (range(1, 50) as $index) {
            do {
                $companyName = $faker->company;
            } while (in_array($companyName, $usedNames));
        
            $companyName = (strpos($companyName, ' ') === false) ? $companyName . ' ' . $faker->randomElement($companySuffixes) : $companyName;
        
            $usedNames[] = $companyName;
        
            $email = $faker->unique()->companyEmail;
        
            $company = Company::create([
                'name' => $companyName,
                'email' => $email,
                'phone' => $generatePhoneNumber(),
                'address' => $faker->address,
            ]);
        
            $companies[] = $company;
        }
        

        /* ******************************************* */
        $positions = [
            [
                'name' => 'Adminisztrátor',
                'description' => 'Az adminisztrátor felelős a vállalati rendszerek és folyamatok irányításáért, az operatív és adminisztratív feladatok elvégzéséért. Feladata lehet az alkalmazottak irányítása, az adatkezelés és a napi működés biztosítása.'
            ],
            [
                'name' => 'Pénztáros',
                'description' => 'A pénztáros feladata az üzletben vagy pénzügyi intézményekben történő tranzakciók lebonyolítása. Ő kezeli a készpénzt, a vásárlásokat, és biztosítja a pénzügyi nyilvántartást.'
            ],
            [
                'name' => 'Raktáros',
                'description' => 'A raktáros feladata a termékek és áruk kezelésében való közreműködés. Feladatai közé tartozik az áruk tárolása, nyilvántartása, illetve a szállítási és áruellenőrzési folyamatok biztosítása.'
            ],
            [
                'name' => 'Recepciós',
                'description' => 'A recepciós a vállalat vagy intézmény első kapcsolattartó személye. Feladata a vendégek és ügyfelek fogadása, információk biztosítása, telefonhívások kezelése és adminisztratív támogatás nyújtása.'
            ],
            [
                'name' => 'Kasszázó',
                'description' => 'A kasszázó a pénztári tranzakciók lebonyolításáért felelős munkatárs. Feladata a vásárlások kezelése, pénzkezelés és a vásárlókkal való közvetlen kapcsolattartás.'
            ],
            [
                'name' => 'Szakács',
                'description' => 'A szakács az éttermek, szállodák és egyéb vendéglátóhelyek étkezési kínálatának elkészítéséért felelős szakember. Feladata az étlapok összeállítása, az étkezések előkészítése és tálalása.'
            ],
            [
                'name' => 'Felszolgáló',
                'description' => 'A felszolgáló a vendégek kiszolgálásáért felelős munkatárs. Feladatai közé tartozik az éttermek, kávézók és szállodák vendégeinek étkezéseinek szervírozása és az igényeik kielégítése.'
            ],
            [
                'name' => 'Kiszerelő',
                'description' => 'A kiszerelő a termékek csomagolásáért, előkészítéséért és kiszereléséért felelős személy. Feladatai közé tartozik az áruk kézi vagy gépi csomagolása, a készletek rendezése és nyilvántartása.'
            ],
            [
                'name' => 'Gyártósori munkás',
                'description' => 'A gyártósori munkás a gyártási folyamatban dolgozik, végrehajtja a szükséges feladatokat a termelési sorokon. Feladata a gépek működtetése, az alapanyagok betöltése, és a termékek minőségi ellenőrzése.'
            ],
            [
                'name' => 'Takarító',
                'description' => 'A takarító a helyiségek, irodák és közterületek tisztán tartásáért felelős munkatárs. Feladata a napi takarítás, szaniter tisztítás és az irodahelyiségek frissítése.'
            ],
            [
                'name' => 'Szerviz technikus',
                'description' => 'A szerviz technikus a különböző gépek, berendezések karbantartásáért, javításáért és üzemeltetéséért felelős szakember. Feladata az eszközök diagnosztizálása, hibák elhárítása és rendszeres karbantartás.'
            ],
            [
                'name' => 'Autószerelő',
                'description' => 'Az autószerelő a gépjárművek javításáért és karbantartásáért felelős szakember. Feladata a motorok, futóművek, fékek és egyéb autóalkatrészek ellenőrzése, cseréje és javítása.'
            ],
            [
                'name' => 'Kertész',
                'description' => 'A kertész a növények gondozásáért és karbantartásáért felelős szakember. Feladata a kertek, parkok, zöldterületek növényeinek ültetése, öntözése, nyírása és a környezet karbantartása.'
            ],
            [
                'name' => 'Építőipari segédmunkás',
                'description' => 'Az építőipari segédmunkás a különböző építkezéseken végez segédmunkát. Feladatai közé tartozik az anyagok előkészítése, eszközök kezelése, és a munkások segítése a napi feladatokban.'
            ],
            [
                'name' => 'Biztonsági őr',
                'description' => 'A biztonsági őr a létesítmények védelméért és a biztonság fenntartásáért felelős személy. Feladata a helyszínek őrzése, a rend és biztonság biztosítása, valamint a belépés ellenőrzése.'
            ],
        ];
        
        $jobPositions = [];
        foreach ($positions as $position) {
            $jobPositions[] = JobPosition::create([
                'title' => $position['name'],
                'description' => $position['description'],
            ]);
        }
        
        
        foreach ($companies as $company) {
            foreach ($jobPositions as $jobPosition) {
                $create_a_job = rand(0, 1) === 1;

                if($create_a_job){
                    $base_salary = round(rand(1500, 2500) / 100) * 100;

                    $hasBonus = rand(0, 1) === 1;
            
                    $rand_night_bonus = [200, 300, 400][array_rand([200, 300, 400])];
                    $rand_weekend_bonus = [300, 400, 500][array_rand([300, 400, 500])];
            
                    if ($hasBonus) {
                        $night_salary = $base_salary + $rand_night_bonus;
                        $weekend_salary = $base_salary + $rand_weekend_bonus;
                    } else {
                        $night_salary = $base_salary;
                        $weekend_salary = $base_salary;
                    }
            
                    $company->jobPositions()->attach($jobPosition->id, [
                        'base_salary' => $base_salary,
                        'night_salary' => $night_salary,
                        'weekend_salary' => $weekend_salary,
                    ]);
                }
            }
        }
                
        /* ******************************************* */

        $startDate = new \DateTime('2025-01-01');
        $endDate = new \DateTime('2025-02-15');
        $createdRecords = 0;
        $totalRecords = 2500;
        $companyJobPositions = DB::table('company_jobs')->get(); 

        while ($createdRecords < $totalRecords) {
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate && $createdRecords < $totalRecords) {
                $numWorkers = rand(5, 50);

                $usedStudents = [];
                for ($i = 0; $i < $numWorkers && $createdRecords < $totalRecords; $i++) {
                    do {
                        $student = $faker->randomElement($students);
                    } while (in_array($student->id, $usedStudents));

                    $companyJobPosition = $companyJobPositions->random();

                    if ($companyJobPosition) {

                        $usedStudents[] = $student->id;
                        $workStartHours = $faker->randomElement([6, 8, 10, 12, 14, 18, 20, 22]);
                        $workDateBegin = $currentDate->setTime($workStartHours, 0, 0)->format('Y-m-d H:i:s');
                        $workDateEnd = (new \DateTime($workDateBegin))->modify('+8 hours')->format('Y-m-d H:i:s');
                        
                        $salaryData = $this->appService->calculateSalary($workDateBegin, $workDateEnd, $companyJobPosition->base_salary, $companyJobPosition->night_salary, $companyJobPosition->weekend_salary);                      

                        WorkRecord::create([
                            'student_id' => $student['id'],
                            'company_job_id' => $companyJobPosition->id,
                            'work_date_begin' => $workDateBegin,
                            'work_date_end' => $workDateEnd,
                            'total_salary' => $salaryData['total_salary'],
                            'calculated' => $salaryData['calculated'],
                            'comment' => '',
                            'student_invoice_id' => '0',
                            'company_invoice_id' => '0'
                        ]);
            
                        $createdRecords++;
                    }
                }                

                $currentDate->modify('+1 day');
            }
        }

        /* ******************************************* */

        
    }
}
