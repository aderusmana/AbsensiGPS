<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pathFoto = 'public/uploads/users/user.png';

        //copy photo public ke storage
        Storage::copy('public/img/user.png',$pathFoto);

        User::create([
            'name' => 'admin',
            'email' => 'admin@wc.com',
            'password' => Hash::make(123),
            'photo' => $pathFoto
        ]);

    }
}
