<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->updateOrCreate(['email' => 'admin@admin.com'], [
            'first_name'    => 'Admin',
            'last_name'     => 'Admin',
            'is_admin'      => true,
            'password'      => \Hash::make('admin')
        ]);
    }
}
