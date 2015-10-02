<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(TipoCategoriaTableSeeder::class);
        $this->call(TipoMidiaTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(FuncaoTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        $this->call(PerfilUserTableSeeder::class);
        $this->call(PermissaoUserTableSeeder::class);
        $this->call(PermissaoPerfilTableSeeder::class);
        $this->call(SobreTableSeeder::class);
        $this->call(EmailTableSeeder::class);
        $this->call(ContatoTableSeeder::class);
        $this->call(ConfiguracaoTableSeeder::class);
        $this->call(AnalyticsTableSeeder::class);
        $this->call(CategoriaTableSeeder::class);
        $this->call(SubcategoriaTableSeeder::class);
        $this->call(StatusComentarioSeeder::class);

        Model::reguard();
    }
}
