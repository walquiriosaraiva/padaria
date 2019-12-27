<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(AdministradorSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(PagamentoSeeder::class);
        $this->call(ContaSeeder::class);
        $this->call(ChequeSeeder::class);
        $this->call(MovimentacaoBancariaSeeder::class);
        $this->call(FuncionarioSeeder::class);
        $this->call(FluxoDiarioSeeder::class);
        $this->call(FolgaSeeder::class);
        $this->call(BoletoSeeder::class);
        $this->call(BancoSeeder::class);
        $this->call(UnidadeMedidaSeeder::class);
    }
}
