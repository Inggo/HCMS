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
        ], [
            'full_name' => 'HCMS Reviewer',
            'email' => 'reviewer@hcms.dev',
            'password' => bcrypt('secret'),
            'type' => 'reviewer',
        ], [
            'full_name' => 'HCMS Handler',
            'email' => 'handler@hcms.dev',
            'password' => bcrypt('secret'),
            'type' => 'handler',
        ], [
            'full_name' => 'Hospital Representative',
            'email' => 'hospital@hcms.dev',
            'password' => bcrypt('secret'),
            'type' => 'representative',
        ], [
            'full_name' => 'Juan Dela Cruz',
            'email' => 'juan@hcms.dev',
            'password' => bcrypt('secret'),
            'type' => 'complainant',
        ]);
    }
}
