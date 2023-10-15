<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsernameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->username = Str::slug($user->name);
            $user->save();
        }

        /*
            // fake about
            $users = User::all();
            foreach ($users as $user) {
                $user->about = fake()->text;
                $user->save();
            }

             // random image
            $users = User::all();
            foreach ($users as $user) {
                $bool = random_int(1, 2);
                $user->image = '/assets/admin/images/user-images/profile' . $bool . '.png';
                $user->save();
            }

        */
    }
}