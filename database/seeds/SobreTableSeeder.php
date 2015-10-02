<?php

use Illuminate\Database\Seeder;

class SobreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sobre')->insert([
            'titulo'    => 'Sobre nós',
            'texto'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus bibendum venenatis arcu, a tristique sapien vestibulum in. In mattis nisi id dolor ornare, quis laoreet ligula efficitur. Suspendisse aliquam justo eget massa luctus scelerisque. Curabitur eleifend molestie massa ut venenatis. Aliquam est arcu, semper sed facilisis id, vehicula eget urna. Donec pulvinar placerat vulputate. Suspendisse eleifend fermentum lobortis. Donec id dolor dictum, posuere tellus in, auctor risus. Nam ut fermentum felis. Morbi ultricies finibus massa. Curabitur euismod convallis lorem ut aliquet. Praesent fermentum tortor urna, id convallis leo semper id. '
        ]);
    }
}
