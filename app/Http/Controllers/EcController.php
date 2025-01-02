<?php

namespace App\Http\Controllers;

use App\Models\elements_constitutifs;
use App\Models\unites_enseignement;
use Illuminate\Http\Request;

class EcController extends Controller
{
    public function index(){
        return view('Ue_and_Ec.index');
    }
    public function create(){
        $Ues = unites_enseignement::all();
        return view('Ue_and_Ec.createEc',['Ues' => $Ues]);
    }
    public function store(Request $request){
        $rules=[
            'code'=>'required|string|min:4|regex:/^EC[0-9]{2}$/',
            'nom'=>'required|string|min:4',
            'coefficient'=>'required|integer',
            'ue_id'=>'required|integer|exists:unites_enseignement,id'
        ];
        $validatedData = $request->validate($rules);
        $ue = unites_enseignement::findOrFail($request->input('ue_id'));
        $coefficientSomme = elements_constitutifs::where('ue_id', $ue->id)->sum('coefficient');

        if (($coefficientSomme + $request->input('coefficient')) > $ue->credits_ects) {
            return back()->withErrors(['coefficient' => 'La somme des coefficients dépasse le nombre de crédits de l\'UE.']);
        }
        $Ec = new elements_constitutifs();
        $Ec -> code = $request->input('code');
        $Ec -> nom = $request->input('nom');
        $Ec -> coefficient = $request->input('coefficient');
        $Ec -> ue_id = $request->input('ue_id');
        $Ec -> save();

        return redirect()->route('index')->with('message', 'EC créé avec succès');

    }
    public function edit(string $id){
        $ec = elements_constitutifs::findOrfail($id);
        $Ues = unites_enseignement::all();
        return view('Ue_and_Ec.editEc', compact('ec','Ues'));
    }
    public function update(Request $request, string $id){
        $Ec = elements_constitutifs::findOrFail($id);

        $ue = unites_enseignement::findOrFail($request->input('ue_id'));
        $coefficientSomme = elements_constitutifs::where('ue_id', $ue->id)
            ->where('id', '!=', $Ec->id) 
            ->sum('coefficient');

        if (($coefficientSomme + $request->input('coefficient')) > $ue->credits) {
            return back()->withErrors(['coefficient' => 'La somme des coefficients dépasse le nombre de crédits de l\'UE.']);
        }
        $Ec -> code = $request->input('code');
        $Ec -> nom = $request->input('nom');
        $Ec -> coefficient = $request->input('coefficient');
        $Ec -> ue_id = $request->input('ue_id');
        $Ec -> update();

        return redirect()->route('index')->with('message', 'EC mis a jour avec succès');

    }
    public function delete(string $id){
        $Ec = elements_constitutifs::findOrFail($id);
        $Ec -> delete();
        return redirect()->route('index')->with('message', 'EC supprimer avec succès');
    }
}
