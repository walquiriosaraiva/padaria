<?php

use Illuminate\Database\Seeder;
use App\Model\Administrador;

class AdministradorSeeder extends Seeder
{
    public function run()
    {
        Administrador::create([
            'nome' => 'Administrador',
            'senha' => bcrypt('admin'),
            'email' => 'walquiriosaraiva@gmail.com',
            'users_id' => 1
        ]);
    }
}