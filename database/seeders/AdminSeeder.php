<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->truncate();
        DB::table('admin_users')->insert([
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$ZCACea2KHBu0P4bIx8.i9.lbyWqOVgc/mtu4oTU/dyFhyiAGwx.0e',//password
            'name' => 'Admin'
        ]);
    }
}
