<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use App\Models\Category;
use App\Models\Rental;
use App\Models\Student;
use App\Models\User;
use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Faker\Provider\ar_JO\Person;
use Faker\Provider\ar_SA\Person as Ar_SAPerson;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $seed = file_get_contents('database/seeders/lmsdump.sql');
       DB::unprepared($seed);

        // // db Users
        //     "username" => "admin@lms.com",
        //     "password" => Hash::make("12258"),
        //     "IsAdmin" => 1
        // ]);

        // // Languages
        // BookLanguage::create([
        //     "Code" => "F",
        //     "Name" => "Français"
        // ]);
        // BookLanguage::create([
        //     "Code" => "A",
        //     "Name" => "عربية"
        // ]);

        // // Categories
        // Category::create([
        //     "Code" => "IN",
        //     "Name" => "إعلام آلي"
        // ]);
        // Category::create([
        //     "Code" => "CH",
        //     "Name" => "كيمياء"
        // ]);
        // Category::create([
        //     "Code" => "M",
        //     "Name" => "رياضيات"
        // ]);
        // Category::create([
        //     "Code" => "PH",
        //     "Name" => "فيزياء"
        // ]);
        // Category::create([
        //     "Code" => "D",
        //     "Name" => "قاموس"
        // ]);
        // Category::create([
        //     "Code" => "ME",
        //     "Name" => "ميكانيك"
        // ]);
        // Category::create([
        //     "Code" => "L",
        //     "Name" => "مطالعة"
        // ]);


        DB::transaction(function (){
            echo "starting transaction\r\n";
            $usernames = collect([]);
            $students = [];
            $rentals = collect([]);
            $copies = BookCopy::all()->all();

            $bookCopiesCount = BookCopy::count();
            foreach(range(0, 1000) as $i)
            {
                $usernames[] = random_int(0, 4222222222);
            }
            $usernames = $usernames->unique();
            $studentsCount = $usernames->count();
            foreach($usernames as $username)
            {
                $user = User::create([
                    'username' => $username,
                    'password' => Hash::make('password')
                ]);
                $students[] = Student::create([
                    User::FOREIGN_KEY => $user->getKey(),
                    Student::KEY => $user->getKey(),
                    'Name' => Str::random(),
                    'Speciality' => Str::random(),
                    'BirthDate' => now(),
                ]);
            }
            foreach(range(0, 4000) as $i)
            {
                $copy = $copies[array_rand($copies)];
                if($copy->rental)
                {
                    continue;
                }
                $student = $students[array_rand($students)];
                $days = -1 * random_int(random_int(0, 49), random_int(random_int(50, 100), 365));
                $rentals[] = $copy->rental()->create([
                    Student::FOREIGN_KEY => $student->getkey(),
                    Book::FOREIGN_KEY => $copy->book->getKey(),
                    'CreatedAt' => now()->addDays($days),
                    'ExpiresAt' => now()->addDays(15)
                ]);
            }
            echo "commiting transaction\r\n";
        });
    }
}
