<?php

use Illuminate\Database\Seeder;

class PermissaoUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissao_user')->insert(['id_funcao' => 1,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 2,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 3,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 4,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 5,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 6,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 7,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 8,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 9,  'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 10, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 11, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 12, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 13, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 14, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 15, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 16, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 17, 'id_user' => 2, 'id_role' => 3]);
        DB::table('permissao_user')->insert(['id_funcao' => 18, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 19, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 20, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 21, 'id_user' => 2, 'id_role' => 1]);
        DB::table('permissao_user')->insert(['id_funcao' => 22, 'id_user' => 2, 'id_role' => 1]);
    }
}