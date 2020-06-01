<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' =>'Đàm Nguyễn',
                'email'=>'damnguyen@gmail.com',
                'password' =>\Illuminate\Support\Facades\Hash::make('123456789')
            ]
        );
        User::create(
            [
                'name' =>'Đức Lê',
                'email'=>'ducle@gmail.com',
                'password' =>\Illuminate\Support\Facades\Hash::make('123456789')
            ]
        );
        User::create(
            [
                'name' =>'Tùng Dương',
                'email'=>'tungduong@gmail.com',
                'password' =>\Illuminate\Support\Facades\Hash::make('123456789')
            ]
        );
        User::create(
            [
                'name' =>'Dũng Mạnh',
                'email'=>'dungmanh@gmail.com',
                'password' =>\Illuminate\Support\Facades\Hash::make('123456789')
            ]
        );
    }
}
