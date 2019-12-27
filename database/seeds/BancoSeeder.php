<?php

use Illuminate\Database\Seeder;
use App\Model\Banco;

class BancoSeeder extends Seeder
{
    public function run()
    {
        Banco::create([
            'nome' => 'Banco do Brasil'
        ]);

        Banco::create([
            'nome' => 'Banco Bradesco'
        ]);

        Banco::create([
            'nome' => 'Caixa Econòmica'
        ]);

        Banco::create([
            'nome' => 'Banco Itaú'
        ]);

        Banco::create([
            'nome' => 'Banco BRB'
        ]);

        Banco::create([
            'nome' => 'Banco HSBC'
        ]);
    }
}