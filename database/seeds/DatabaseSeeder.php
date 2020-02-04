<?php

use App\User;
use App\Question;
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
        // $this->call(UsersTableSeeder::class);
        factory(User::class, 3)->create()->each(function ($u) {
            $u->questions() //has many
                ->saveMany( //guarda a BD
                    factory(Question::class, rand(1, 5))->make() //make hace objetos en vez de registros en BD
                );
        });
    }
}
