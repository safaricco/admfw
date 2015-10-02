<?php

namespace App\Http\Controllers;

use App\Models\Midia;
use App\Models\Multimidia;
use App\Models\TipoMidia;
use Illuminate\Http\Request;
use App\Models\Banner;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Imagem extends Controller
{
    /*
     * exemplo de uso
     *
     * <img src="{{ url('thumb/250/250/dicas/2c72c6f92ac422d2cfa8332f1f70e2a2.jpg') }}" alt="">
     * <img src="{{ url('thumb/348/null/' . $tipo . '/' . $img->imagem) }}" class="img-responsive">
     *
     * @param  int      $width      comprimento a ser redimencionada, se quiser que seja proporcional a altura, basta passar null
     * @param  int      $height     altura a ser redimencionada, se quiser que seja proporcional ao comprimento, basta passar null
     * @param  string   $tipo       o tipo é o nome da subpasta (que deve ser igual na tabela tipo_midia) que está dentro da pasta uploads que contem a imagem do parametro $img
     * @param  string   $img        nome da imagem que vem do banco (tabela multimidia)
     *
     * */
    public function thumb($width, $height, $tipo, $img)
    {
        if ( ! is_file('uploads/' . $tipo . '/thumb-' . $width . 'x' . $height . '_' . $img)) :

            $image = Image::make('uploads/' . $tipo . '/' . $img);

            $image->resize($width, $height,
                function ($constraint) {
                    $constraint->aspectRatio(); // mantem a proporção da imagem, se caso a altura ou largura forem nullos
                    $constraint->upsize();      // não deixa estrourar o tamanho original

            })->save(public_path() . '/uploads/' . $tipo . '/thumb-' . $width . 'x' . $height . '_' . $img);

        endif;

        header('Content-Type: image/jpg');
        readfile('uploads/' . $tipo . '/thumb-' . $width . 'x' . $height . '_' . $img);
    }

    /*
     * Função que deleta somente uma imagem, serve para qualquer controlador
     *
     * esta funcão é acionada por ajax
     *
     * */
    public function destroyFoto(Request $request)
    {
        Multimidia::excluir($request->id);

        session()->flash('flash_message', 'Registro apagado com sucesso');
    }
}