<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([

            [
            'name'      =>  'Admin',
            'usertype'  =>  1,
            'email'     =>  'nirmal.j@webandcrafts.in',
            'password'  =>  Hash::make('password'),
            'status'    =>  1
            ],

            [
            'name'      => 'Tressa',
            'usertype'  =>  0,
            'email'     => 'nirmal.j@webandcrafts.in',
            'password'  =>  Hash::make('password'),
            'status'    =>  1

            ],
            ]);
    }
}
