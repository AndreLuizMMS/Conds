<?php

namespace App\Http\Controllers;

use App\Models\cond_sindico;
use App\Models\Condominio;
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

        return view(
            'Admin.edit-cond',
            ['cond' => $cond, 'user' => auth()->user(), 'sindicos' => $sindicos]
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

        if ($currentSindico) {
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

    function deleteSindico($id) {
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
}
