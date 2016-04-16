<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => 'HCMS Administrator',
            'email' => 'administrator@hcms.dev',
            'password' => bcrypt('secret'),
            'type' => 'administrator',
        ]);
    }
}
