<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'superadmin';
        $user->email = 'superadmin@gmail.com';
        $user->password = Hash::make('qwerty');
        $user->role_id = User::ROLE_SUPERADMIN;
        $user->save();
    }
}
