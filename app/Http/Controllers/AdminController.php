<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Morador;
use App\Models\morador_apartamento;
use App\Models\Sindico;
use Database\Seeders\Condominios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    function home() {
        return view('Admin.home', ['user' => auth()->user()]);
    }

    public function listCondominios() {
        $conds = Condominio::all();

        return view('Admin.condominios', ['conds' => $conds, 'user' => auth()->user()]);
    }

    function listSindicos() {
        $sindicos = Sindico::all();
        return view('Admin.sindicos', ['sindicos' => $sindicos, 'user' => auth()->user()]);
    }

    function listMoradores() {

        $moradores = Condxmino::select('condxminos.nome', 'morador.apartamento', 'apartamento.condominio', 'condominios.nome as nomeCondominio', 'morador.condx_id as idMorador')
            ->from('condxminos')
            ->join('morador', 'morador.condx_id', '=', 'condxminos.id')
            ->join('apartamento', 'morador.apartamento', '=', 'num_ap')
            ->join('condominios', 'apartamento.condominio', '=', 'condominios.id')
            ->get();

        // dd($moradores);

        return view('Admin.moradores', ['user' => auth()->user(), 'moradores' => $moradores]);
    }

    // condominio CRUD
    function addCondominio(Request $req) {
        $form = $req->validate([
            'nome' => 'required'
        ]);

        $cond = Condominio::where('nome', $req->nome);
        if ($cond->exists()) {
            return back()->withErrors(['nome' => 'Condominio já existe']);
        }
        Condominio::create($form);
        return back();
    }

    function deleteCondominio($id) {
        $cond = Condominio::find($id);

        if ($cond) {
            $cond->delete();
        }
        return back();
    }

    function editCondominio($id) {
        $cond = Condominio::find($id);

        $sindicos = Sindico::select('sindicos.nome', 'cond_sindico.turno', 'sindicos.id')
            ->from('sindicos')
            ->join('cond_sindico', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->where('cond_sindico.id_condominio', $id)
            ->get();

        $apartamentos = Apartamento::select('num_ap', 'condominio', 'id_proprietario')
            ->from('apartamento')
            ->where('condominio', $id)
            ->get();

        return view(
            'Admin.edit-cond',
            ['cond' => $cond, 'user' => auth()->user(), 'sindicos' => $sindicos, 'apartamentos' => $apartamentos]
        );
    }

    function editNomeCondominio($id, Request $req) {
        $form = $req->validate([
            'nome' => 'required'
        ]);

        $exists = Condominio::where('nome', $form['nome'])->exists();
        if ($exists) {
            return back()->withErrors(['nome' => 'Condominio já existe']);
        }

        $cond = Condominio::find($id);
        $cond->nome = $form['nome'];
        $cond->save();

        return back();
    }

    function addSindico($id, Request $req) {
        $form = $req->validate([
            'nome' => 'required',
            'turno' => 'required'
        ]);
        $form['nome'] = trim($form['nome']);

        // sindicos daquele condominio
        $sindicos = Sindico::select('sindicos.nome', 'cond_sindico.turno', 'sindicos.id')
            ->from('sindicos')
            ->join('cond_sindico', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->get();

        $currentSindico = Sindico::where('nome', $form['nome'])->get();
        if (!$currentSindico) {
            foreach ($sindicos as $sindico) {
                if ($form['nome'] == $sindico->nome && $form['turno'] == $sindico->turno) {
                    return back()->withErrors(['nome' => 'Sindico ativo']);
                }
            }
        }
        foreach ($sindicos as $sindico) {
            if ($form['turno'] == $sindico->turno) {
                return back()->withErrors(['nome' => 'Turno ou Sindico ocupado']);
            }
        }

        $formSindico = Sindico::where('nome', $form['nome']);
        if (!$formSindico->exists()) {
            $newSindico = Sindico::create(['nome' => $form['nome']]);

            cond_sindico::create([
                'id_sindico' => $newSindico->id,
                'id_condominio' => $id,
                'turno' => $form['turno']
            ]);
        } else {
            cond_sindico::create([
                'id_sindico' => $currentSindico[0]->id,
                'id_condominio' => $id,
                'turno' => $form['turno']
            ]);
        }


        return back();
    }

    function deleteSindicoAtivo($id) {
        //sindicos daquele condominio
        $sindicos = Sindico::select('sindicos.nome', 'cond_sindico.turno', 'sindicos.id')
            ->from('sindicos')
            ->join('cond_sindico', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->get();

        foreach ($sindicos as $sindico) {
            if ($sindico->id == $id);
            $relation = cond_sindico::where('id_sindico', $id)->get();

            foreach ($relation as $item) {
                $item->delete();
            }

            return back()->withErrors(['nome' => 'Sindico excluído']);
        }
    }

    // CRUD Sindicos ------------------------------------

    function editSindico($id) {
        $sindico = Sindico::find($id);

        $turnos = Sindico::select('sindicos.id', 'condominios.nome', 'cond_sindico.turno')
            ->from('sindicos')
            ->join('cond_sindico', 'cond_sindico.id_sindico', '=', 'sindicos.id')
            ->join('condominios', 'cond_sindico.id_condominio', '=', 'condominios.id')
            ->get();


        return view(
            'Admin.edit-sindico',
            ['user' => auth()->user(), 'sindico' => $sindico, 'turnos' => $turnos]
        );
    }


    function editNomeSindico($id, Request $req) {
        $form = $req->validate(['novoNome' => 'required']);

        $sindico = Sindico::find($id);
        $sindico->nome =  $form['novoNome'];
        $sindico->save();

        return back();
    }

    function deleteSindico($id) {
        $sindico = Sindico::find($id);

        if ($sindico->exists()) {
            $turnos = cond_sindico::where('id_sindico', $id)->get();
            foreach ($turnos as $turno) {
                $turno->delete();
            }
            $sindico->delete();
        }

        return back();
    }

    function editApartamento($idCondominio, $num_ap) {
        $moradores = Morador::select('condxminos.nome', 'morador.apartamento')
            ->join('condxminos', 'morador.condx_id', '=', 'condxminos.id')
            ->where('morador.apartamento', $num_ap)
            ->get();

        // dd($moradores);

        return view(
            'Admin.edit-apartamento',
            [
                'user' => auth()->user(),
                'moradores' => $moradores,
                'num_ap' => $num_ap,
                'idCondominio' => $idCondominio
            ]
        );
    }

    function deleteMorador($condx_id, $numAp) {
        $deletedMorador = Morador::where('condx_id', $condx_id)
            ->where('apartamento', $numAp)
            ->delete();

        return back();
    }

    function addMorador(Request $req, $idCondominio, $num_ap) {
        $form = $req->validate([
            'addMorador' => 'required'
        ]);
        $form['addMorador'] = trim($form['addMorador']);

        $moradorExiste = Condxmino::where('nome', $form['addMorador'])->exists();
        if (!$moradorExiste) {
            $newMorador = Condxmino::create([
                'nome' => $form['addMorador']
            ]);

            Morador::create([
                'condx_id' => $newMorador->id,
                'apartamento' => $num_ap,
                'condominio' => $idCondominio
            ]);
        }

        return back();
    }

    function deleteCondxminoMorador($idMorador) {
        $deletedCondxMorador = Condxmino::find($idMorador);
        Morador::where('condx_id', $deletedCondxMorador->id)->delete();
        $deletedCondxMorador->delete();

        return back();
    }
}
