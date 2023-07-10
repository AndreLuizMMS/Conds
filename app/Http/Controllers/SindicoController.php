<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Sindico;

class SindicoController extends Controller {

    function home() {
        return view('Sindico.home', ['user' => auth()->user()]);
    }

    function listCondominio() {
        $condominios = Condominio::select('condominios.nome', 'condominios.id')
            ->where('sindicos.nome', auth()->user()->name)
            ->join('cond_sindico', 'condominios.id', '=', 'id_condominio')
            ->join('sindicos', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->get();

        return view('Sindico.condominio', ['condominios' => $condominios]);
    }

    function infoCondominio($id) {
        $cond = Condominio::find($id);

        $sindicos = Sindico::select('sindicos.nome', 'cond_sindico.turno', 'sindicos.id')
            ->from('sindicos')
            ->join('cond_sindico', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->where('cond_sindico.id_condominio', $id)
            ->get();

        $apartamentos = Apartamento::select('num_ap', 'id', 'condominio')
            ->from('apartamento')
            ->where('condominio', $id)
            ->get();
        return view(
            'Sindico.info-condominio',
            [
                'cond' => $cond, 'user' => auth()->user(),
                'sindicos' => $sindicos,
                'apartamentos' => $apartamentos,
            ]
        );
    }

    function listApartamento($idCondominio,  $idApartamento, $numAp) {
        $moradores = Condxmino::select(
            'condxminos.nome',
        )
            ->join('morador', 'condxminos.id', '=', 'morador.condx_id')
            ->where('morador.apartamento_id', $idApartamento)
            ->get();

        $proprietario = Condxmino::select('nome')
            ->join('proprietario', 'condxminos.id', '=', 'proprietario.condx_id')
            ->join('apartamento', 'proprietario.apartamento_id', '=', 'apartamento.id')
            ->get();

        return view('Sindico.apartamento', [
            'user' => auth()->user(),
            'moradores' => $moradores,
            'num_ap' => $numAp,
            'idApartamento' => $idApartamento,
            'idCondominio' => $idCondominio,
            'proprietario' => $proprietario[0] ?? false
        ]);
    }

    function listTurnos() {
        $turnos = cond_sindico::select('cond_sindico.turno', 'condominios.nome as condominio', 'sindicos.nome as sindico')
            ->join('condominios', 'cond_sindico.id_condominio', '=', 'condominios.id')
            ->join('sindicos', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->get();

        return view('Sindico.turnos', ['turnos' => $turnos]);
    }
}
