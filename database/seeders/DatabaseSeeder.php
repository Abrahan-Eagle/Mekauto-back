<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

          // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         // \App\Models\User::factory(10)->create();



          // \App\Models\User::factory(10)->create();
        //Blog::factory(10)->create();
        //Blog::factory()->count(10)->create();


        $this->call([

            //CONTRIES STATES CITIES
            //CountriesSeeder::class,
            //StatesSeeder::class,
            //CitiesSeeder::class,

            //VEHICULE DATA
            VehicleTypesSeeder::class,
            MarksSeeder::class,
            YearsSeeder::class,
            CarModelsSeeder::class,



            //PermissionSeeder::class,
            //UserSeeder::class,
            //FRONT
            //EventsSeeder::class,
            //SermonSeeder::class,
            //TestimonioSeeder::class,
            //VideoheroSeeder::class,
            //HistoryaboutSeeder::class,

            //BLOG
            //AuthorSeeder::class,
            //CategorySeeder::class,
            //TagSeeder::class,
            PostsSeeder::class,

         ]);



    }
}
