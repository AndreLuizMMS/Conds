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

        return view('Admin.condominios', ['conds' => $conds]);
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
        return view('Admin.edit-cond', ['cond' => $cond]);
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

        // dd($form);

        // $currentSindico = Sindico::where('nome', $form['nome']);
        // if ($currentSindico->exists()) {
        //     $currentSindico->name = $form['nome'];
        //     $currentSindico->turno = $form['turno'];
        //     return redirect('/');
        // }

        $newSindico = Sindico::create(['nome' => $form['nome']]);
        cond_sindico::create([
            'id_sindico' => $newSindico->id,
            'id_condominio' => $id,
            'turno' => $form['turno']
        ]);

        return redirect('/');
    }
}
