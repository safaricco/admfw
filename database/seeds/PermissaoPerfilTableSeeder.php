<?php

use Illuminate\Database\Seeder;

class PermissaoPerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADICIONANDO A PERMISSÃO PARA O PERFIL ADMIN
        DB::table('permissao_perfil')->insert(['id_funcao' => 1,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 2,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 3,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 4,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 5,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 6,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 7,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 8,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 9,  'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 10, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 11, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 12, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 13, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 14, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 15, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 16, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 17, 'id_perfil' => 1, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 18, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 19, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 20, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 21, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 22, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 23, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 24, 'id_perfil' => 1, 'id_role' => 2]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 25, 'id_perfil' => 1, 'id_role' => 2]);

        // ADICIONANDO A PERMISSÃO PARA O PERFIL COLABORADOR
        DB::table('permissao_perfil')->insert(['id_funcao' => 1,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 2,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 3,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 4,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 5,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 6,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 7,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 8,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 9,  'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 10, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 11, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 12, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 13, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 14, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 15, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 16, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 17, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 18, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 19, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 20, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 21, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 22, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 23, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 24, 'id_perfil' => 2, 'id_role' => 3]);
        DB::table('permissao_perfil')->insert(['id_funcao' => 25, 'id_perfil' => 2, 'id_role' => 3]);
    }
}
