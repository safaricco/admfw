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

        $this->call(TipoMidiaTableSeeder::class);
        $this->call(AnalyticsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(TipoCategoriaTableSeeder::class);
        $this->call(CategoriaTableSeeder::class);
//        $this->call(ClientesTableSeeder::class);      TODO: Adicionar registros seed Clientes
//        $this->call(ComentariosTableSeeder::class);   TODO: Adicionar registros seed Comentários
        $this->call(ConfiguracaoTableSeeder::class);
        $this->call(ContatoTableSeeder::class);
//        $this->call(DepoimentosTableSeeder::class);   TODO: Adicionar registros seed Depoimentos
//        $this->call(DestaquesTableSeeder::class);     TODO: Adicionar registros seed Destaques
//        $this->call(DicasTableSeeder::class);         TODO: Adicionar registros seed Dicas
//        $this->call(DownloadTableSeeder::class);      TODO: Adicionar registros seed Download
        $this->call(EmailTableSeeder::class);
//        $this->call(EquipeTableSeeder::class);        TODO: Adicionar registros seed Equipe
//        $this->call(EventosTableSeeder::class);       TODO: Adicionar registros seed Eventos
//        $this->call(FotosTableSeeder::class);         TODO: Adicionar registros seed Fotos
        $this->call(FuncaoTableSeeder::class);
        $this->call(HelpTableSeeder::class);
//        $this->call(ImoveisTableSeeder::class);       TODO: Adicionar registros seed Imoveis
//        $this->call(NoticiasTableSeeder::class);      TODO: Adicionar registros seed Noticias
//        $this->call(ParceirosTableSeeder::class);     TODO: Adicionar registros seed Parceiros
//        $this->call(PatrocinadorTableSeeder::class);  TODO: Adicionar registros seed Patrocinador
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        $this->call(PerfilUserTableSeeder::class);
        $this->call(PermissaoPerfilTableSeeder::class);
        $this->call(PermissaoUserTableSeeder::class);
//        $this->call(ProdutosTableSeeder::class);      TODO: Adicionar registros seed Produtos
//        $this->call(ProgramasTableSeeder::class);     TODO: Adicionar registros seed Programas
//        $this->call(ServicosTableSeeder::class);      TODO: Adicionar registros seed Servicos
        $this->call(SobreTableSeeder::class);
        $this->call(StatusComentarioSeeder::class);
        $this->call(SubcategoriaTableSeeder::class);
//        $this->call(VideosTableSeeder::class);        TODO: Adicionar registros seed Videos

        Model::reguard();
    }
}
