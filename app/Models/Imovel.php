<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    protected $table        = 'imoveis';
    protected $fillable     = ['id_subcategoria', 'ref','titulo','descricao','obs','valor','rua','bairro','cidade','estado','numero','cep','latitude','longitude','dimensoes','area_terreno','area_construida','area_privativa','area_util','andares','elevadores','tipo_piso','quartos','suites','garagem','banheiros','detalhes','valor_iptu','sala_jantar','sala_estar','sala_tv','cozinha','area_de_servico','dependencia_empregada','gas_central','playground','lavabo','churrasqueira','salao_festas','sacada','portao_eletronico','status'];
    protected $primaryKey   = 'id_imovel';

    public function subcategoria()
    {
        return $this->belongsTo('App\Models\Subcategoria', 'id_subcategoria');
    }
}
