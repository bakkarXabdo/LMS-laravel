<?php

namespace Database\Seeders;

use App\Models\BookLanguage;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $seed = file_get_contents('database/seeders/lms.sql');
//        DB::unprepared($seed);

        // db Users
        User::create([
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
    }
}
