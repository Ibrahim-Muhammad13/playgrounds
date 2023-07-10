<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->insert([
            "name"=>"admin",
            "email"=>"admin@admin.com",
            'password'=>\Hash::make(env('ADMIN_PASS')),
            'role'=>"admin",
            "phone"=>"01144078667"
        ]);
    }
}
