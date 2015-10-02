<?php

namespace App\Http\Controllers\Admin;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Newsletters extends Controller
{

    public function index()
    {
        $dados['newsletters'] = Newsletter::all();
        return view('admin/newsletter/newsletter', $dados);
    }

    public function destroy($id)
    {
        Newsletter::destroy($id);

        session()->flash('flash_message', 'Registro apagado com sucesso');

        return redirect('admin/newsletter/listar');
    }
}
