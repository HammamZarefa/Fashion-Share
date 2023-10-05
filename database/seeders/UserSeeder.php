<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Admin::insert([
            'name'=>'test',
            'email'=>'mohammedassi@gmail.com',
            'username'=>'admin',
            'password'=>bcrypt('admin')
        ]);
    }
}
