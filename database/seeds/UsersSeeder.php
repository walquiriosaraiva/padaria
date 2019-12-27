<?php

use Illuminate\Database\Seeder;
    use App\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'password' => bcrypt('admin'),
            'email' => 'walquiriosaraiva@gmail.com'
        ]);

        User::create([
            'name' => 'Gerente',
            'password' => bcrypt('admin'),
            'email' => 'gerente@gmail.com'
        ]);
    }
}