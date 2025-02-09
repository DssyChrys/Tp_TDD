<?php

namespace App\Http\Controllers;

use App\Models\unites_enseignement;
use Illuminate\Http\Request;

class UeController extends Controller
{
    public function index(){
        $Ues = unites_enseignement::with('elements_constitutifs')->get();
        return view('Ue_and_Ec.index', compact('Ues'));
    }
    public function create(){
        return view('Ue_and_Ec.createUe');
    }
    public function store(Request $request){
        $rules=[
            'code'=>'required|string|min:4|regex:/^UE[0-9]{2}$/',
            'nom'=>'required|string|min:4',
            'credits_ects'=>'required|integer|max:30',
            'semestre'=>'required|integer|min:1|max:6'
        ];
        $validatedData = $request->validate($rules);
        $Ue = new unites_enseignement();
        $Ue -> code = $request->input('code');
        $Ue -> nom = $request->input('nom');
        $Ue -> credits_ects = $request->input('credits_ects');
        $Ue -> semestre = $request->input('semestre');
        $Ue -> save();
        return redirect()->route('index');
    }

    public function delete(string $id){
        $Ue = unites_enseignement::findOrFail($id);
        $Ue-> delete();
        return redirect()->route('index');
    }
}
