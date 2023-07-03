<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Morador;
use App\Models\Proprietario;
use App\Models\Sindico;
use Illuminate\Http\Request;

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
        $moradores = Condxmino::select(
            'condxminos.nome as nomeMorador',
            'apartamento.num_ap',
            'condominios.nome as nomeCond',
            'condxminos.id as idMorador'
        )
            ->join('morador', 'condxminos.id', '=', 'morador.condx_id')
            ->join('apartamento', 'morador.apartamento_id', '=', 'apartamento.id')
            ->join('condominios', 'apartamento.condominio', '=', 'condominios.id')
            ->get();


        return view('Admin.moradores', ['user' => auth()->user(), 'moradores' => $moradores]);
    }

    // CRUD Condominios ------------------------------------------------------------------------

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

        $apartamentos = Apartamento::select('num_ap', 'id', 'condominio')
            ->from('apartamento')
            ->where('condominio', $id)
            ->get();
        return view(
            'Admin.edit-cond',
            [
                'cond' => $cond, 'user' => auth()->user(),
                'sindicos' => $sindicos,
                'apartamentos' => $apartamentos,
            ]
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

        $currentSindico = Sindico::where('nome', $form['nome'])->exists();
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
            if ($sindico->id == $id) {
                $relation = cond_sindico::where('id_sindico', $id)->get();

                foreach ($relation as $item) {
                    $item->delete();
                }
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
            [
                'user' => auth()->user(),
                'sindico' => $sindico,
                'turnos' => $turnos
            ]
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

    function editApartamento($idCondominio, $numAp, $idApartamento) {
        $moradores = Condxmino::select('condxminos.nome')
            ->join('morador', 'condxminos.id', '=', 'morador.condx_id')
            ->join('apartamento', 'morador.apartamento_id', '=', 'apartamento.id')
            ->join('condominios', 'apartamento.condominio', '=', 'condominios.id')
            ->where('apartamento.num_ap', $numAp)
            ->get();


        $proprietario = Condxmino::select('nome', 'apartamento.num_ap')
            ->join('proprietario', 'condxminos.id', '=', 'proprietario.condx_id')
            ->join('apartamento', 'proprietario.apartamento_id', '=', 'apartamento.id')
            ->where('proprietario.apartamento_id', $idApartamento)
            ->where('proprietario.condominio', $idCondominio)
            ->get();

        return view(
            'Admin.edit-apartamento',
            [
                'user' => auth()->user(),
                'moradores' => $moradores,
                'num_ap' => $numAp,
                'idApartamento' => $idApartamento,
                'idCondominio' => $idCondominio,
                'proprietario' => $proprietario[0] ?? false
            ]
        );
    }

    function deleteMorador($condx_id) {
        Morador::where('condx_id', $condx_id)->delete();
        return back();
    }

    function addMorador(Request $req, $idCondominio, $num_ap, $idApartamento) {
        $form = $req->validate([
            'addMorador' => 'required'
        ]);
        $form['addMorador'] = trim($form['addMorador']);


        $condxminoExiste = Condxmino::where('nome', $form['addMorador']);
        if ($condxminoExiste->exists()) {

            $idMoradorExiste = $condxminoExiste->get()[0]->id;
            $moradorExiste = Morador::where('condx_id', $idMoradorExiste);

            if (!$moradorExiste->exists()) {
                $moradorExiste = $moradorExiste->get();

                Morador::create([
                    'condx_id' => $idMoradorExiste,
                    'apartamento_id' => $idApartamento,
                    'condominio' => $idCondominio
                ]);
            }
            return back()->withErrors(['addMorador' => 'Condômino já vinculado à um apartamento']);
        } else {

            $novoCondxmino = Condxmino::create([
                'nome' => $form['addMorador']
            ]);

            Morador::create([
                'condx_id' => $novoCondxmino->id,
                'apartamento_id' => $idApartamento,
                'condominio' => $idCondominio
            ]);
            return back()->withErrors(['addMorador' => 'Condômino vinculado com sucesso']);
        }

        return back();
    }

    function deleteCondxminoMorador($idMorador) {
        $deletedCondxMorador = Condxmino::find($idMorador);

        Morador::where('condx_id', $deletedCondxMorador->id)->delete();
        $deletedCondxMorador->delete();

        return back();
    }

    function defineProprietario($idCondominio, $num_ap, $idApartamento, Request $req) {
        $form = $req->validate([
            'novoProprietario' => 'required'
        ]);
        $form['novoProprietario'] = trim($form['novoProprietario']);

        $condominoExiste = Condxmino::where('nome', $form['novoProprietario']);
        if ($condominoExiste->exists()) {

            $idCondominoExiste = $condominoExiste->get()[0]->id;
            Proprietario::create([
                'condx_id' => $idCondominoExiste,
                'apartamento_id' => $idApartamento,
                'condominio' => $idCondominio
            ]);

            return back()->withErrors(['novoProprietario' => 'proprietario definido com sucesso']);
        }

        $novoCondx = Condxmino::create([
            'nome' => $form['novoProprietario']
        ]);

        Proprietario::create([
            'condx_id' => $novoCondx->id,
            'apartamento_id' => $idApartamento,
            'condominio' => $idCondominio
        ]);

        return back()->withErrors(['novoProprietario' => 'Novo condômino definido como proprietario']);
    }

    function listProprieatrios() {
        $proprietarios = Proprietario::select(
            'condxminos.nome as propNome',
            'proprietario.apartamento_id as idApartamento',
            'apartamento.num_ap as num_ap',
            'condominios.nome as nomeCond',
            'condominios.id as idCond',
            'condxminos.id as idProp'
        )
            ->join('condxminos', 'proprietario.condx_id', 'condxminos.id')
            ->join('condominios', 'proprietario.condominio', 'condominios.id')
            ->join('apartamento', 'proprietario.apartamento_id', '=', 'apartamento.id')
            ->get();


        return view(
            'Admin.proprietarios',
            ['user' => auth()->user(), 'proprietarios' => $proprietarios]
        );
    }

    function deleteProprietario($idProp, $idCond, $num_ap) {
        Proprietario::where('condx_id', $idProp)
            ->where('apartamento', $num_ap)
            ->where('condominio', $idCond)
            ->delete();

        return back();
    }
}
