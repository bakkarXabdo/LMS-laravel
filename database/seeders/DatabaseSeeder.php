<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use App\Models\Category;
use App\Models\Rental;
use App\Models\RentalHistory;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function __construct()
    {
        $this->females = collect(json_decode(file_get_contents('database/seeders/females.json')));
        $this->males = collect(json_decode(file_get_contents('database/seeders/males.json')));
        $this->last = collect(json_decode(file_get_contents('database/seeders/last.json')));
        $this->specialities = collect([
            "إعلام آلي",
            "رياضيات",
            "فيزياء",
            "كيمياء",
            "ميكانيك"
        ]);
    }

    private function rand($digits, $min, $max)
    {
        $str = (string) random_int($min, $max);
        if(strlen($str) < $digits)
        {
            foreach(range(1, $digits - strlen($str)) as $_)
            {
                $str = '0'.$str;
            }
        }
        return $str;
    }
    private function randomName()
    {
        return (random_int(0, 100) > 40 ? $this->females->random() : $this->males->random()) . " " . $this->last->random();
    }

    private function randomSpeciality()
    {
        return $this->specialities->random();
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'Name' => 'أبوبكر بكوش',
            "username" => "admin@lms.com",
            "password" => Hash::make("12258"),
            "IsAdmin" => 1
        ]);

        // Languages
        BookLanguage::create([
            "Code" => "F",
            "Name" => "Français"
        ]);
        BookLanguage::create([
            "Code" => "A",
            "Name" => "عربية"
        ]);

        // Categories
        Category::create([
            "Code" => "IN",
            "Name" => "إعلام آلي"
        ]);
        Category::create([
            "Code" => "CH",
            "Name" => "كيمياء"
        ]);
        Category::create([
            "Code" => "M",
            "Name" => "رياضيات"
        ]);
        Category::create([
            "Code" => "PH",
            "Name" => "فيزياء"
        ]);
        Category::create([
            "Code" => "D",
            "Name" => "قاموس"
        ]);
        Category::create([
            "Code" => "ME",
            "Name" => "ميكانيك"
        ]);
        Category::create([
            "Code" => "L",
            "Name" => "مطالعة"
        ]);

        $seed = file_get_contents('database/seeders/lmsdump.sql');
        DB::unprepared($seed);

        Auth::login($admin);

        DB::transaction(function (){
            echo "starting transaction\r\n";
            $usernames = collect([]);
            $students = [];
            $rentals = collect([]);
            $copies = BookCopy::all()->all();

            foreach(range(0, 1000) as $i)
            {
                $usernames[] = random_int(16, 20).random_int(16, 20).$this->rand(2, 1, 48).$this->rand(6, 0, 999999);
            }
            $usernames = $usernames->unique();
            foreach($usernames as $username)
            {
                $user = User::create([
                    'Name' => $this->randomName(),
                    'username' => $username,
                    'password' => Hash::make('password')
                ]);
                $students[] = Student::create([
                    User::FOREIGN_KEY => $user->getKey(),
                    Student::KEY => $username,
                    'Name' => $user->Name,
                    'Speciality' => $this->randomSpeciality(),
                    'BirthDate' => now(),
                ]);
            }
            foreach(range(0, 4000) as $i)
            {
                $i = array_rand($copies);
                $copy = $copies[$i];
                $student = $students[array_rand($students)];
                $createdAt = Carbon::now()->subDays(random_int(10, 60));

                $rentals[] = $copy->rental()->create([
                    'CreatedBy' => auth()->user()->Name,
                    Student::FOREIGN_KEY => $student->getkey(),
                    Book::FOREIGN_KEY => $copy->book->getKey(),
                    'CreatedAt' => $createdAt,
                    'ExpiresAt' => random_int(0, 10000) === 100
                                                        ? now()->subDays(random_int(random_int(5, 10), 15))
                                                        : now()->addDays(random_int(1, random_int(2, random_int(2, 9)))),
                ]);
                $copy->increment("TotalRentals");
                $copy->book->increment("TotalRentals");
                $copy->book->increment("Popularity");
                $student->increment("TotalRentals");
                unset($copies[$i]);
            }
            $copies = BookCopy::with('book')->get();
            foreach(range(0, 1000) as $i)
            {
                $student = $students[array_rand($students)];
                $copy = $copies->random();
                $createdAt = Carbon::now()->subDays(random_int(16, 60));
                $expires = $createdAt->addDays(random_int(10, 15));
                $returned = random_int(0, 100) > 90 ? $expires->addDays(random_int(2, random_int(5, 10))) : $expires->subDays(random_int(2, 6));
                RentalHistory::create([
                    'CreatedBy' => auth()->user()->Name,
                    'ReturnedBy' => auth()->user()->Name,
                    BookCopy::FOREIGN_KEY => $copy->getKey(),
                    Book::FOREIGN_KEY => $copy->book->getKey(),
                    Student::FOREIGN_KEY => $student->getKey(),
                    'StudentName' => $student->Name,
                    'BookTitle' => $copy->book->Title,
                    'RentalCreatedAt' => $createdAt,
                    'RentalExpiresAt' => $expires,
                    RentalHistory::CREATED_AT => $returned,
                ]);
                $student->increment("TotalRentals");
                $copy->increment("TotalRentals");
                $copy->book->increment("TotalRentals");
                $copy->book->increment("Popularity");
            }
            echo "commiting transaction\r\n";
        });
    }
}
