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
            'code'=>'required|string|min:4',
            'nom'=>'required|string|min:4',
            'credit'=>'required|integer',
            'semestre'=>'required|integer'
        ];
        $validatedData = $request->validate($rules);
        $Ue = new unites_enseignement();
        $Ue -> code = $request->input('code');
        $Ue -> nom = $request->input('nom');
        $Ue -> credits_ects = $request->input('credit');
        $Ue -> semestre = $request->input('semestre');
        $Ue -> save();
        return redirect()->route('index');
    }
}
