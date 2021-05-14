<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'email'=>'admin@admin.com',
                'role'=>'admin',
                'password'=>Hash::make('password'),
            ),
            array(
                'name'=>'User',
                'email'=>'user@user.com',
                'role'=>'user',
                'password'=>Hash::make('password'),
            ),
        );

        DB::table('users')->insert($data);
    }
}
