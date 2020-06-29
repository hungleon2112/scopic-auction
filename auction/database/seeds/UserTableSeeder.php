<?php

use App\Model\Users;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'admin@admin.com',
                'name' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 2
            ]
        ];
        foreach ($users as $index => $user) {
                Users::firstOrCreate(
                [ 'email' => $user['email'] ],
                $user
            );
        }

    }
}
