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
            'code'=>'required|string|min:4',
            'nom'=>'required|string|min:4',
            'coefficient'=>'required|integer',
            'Ue_id'=>'required|integer'
        ];
        $validatedData = $request->validate($rules);
        $Ec = new elements_constitutifs();
        $Ec -> code = $request->input('code');
        $Ec -> nom = $request->input('nom');
        $Ec -> coefficient = $request->input('coefficient');
        $Ec -> ue_id = $request->input('Ue_id');
        $Ec -> save();
        return redirect()->route('index');
    }
    public function edit(string $id){
        $ec = elements_constitutifs::findOrfail($id);
        $Ues = unites_enseignement::all();
        return view('Ue_and_Ec.editEc', compact('ec','Ues'));
    }
    public function update(Request $request, string $id){
        $Ec = elements_constitutifs::findOrFail($id);
        $Ec -> code = $request->input('code');
        $Ec -> nom = $request->input('nom');
        $Ec -> coefficient = $request->input('coefficient');
        $Ec -> ue_id = $request->input('Ue_id');
        $Ec -> update();
        return redirect()->route('index');
    }
    public function delete(string $id){
        $Ec = elements_constitutifs::findOrFail($id);
        $Ec -> delete();
        return redirect()->route('index');
    }
}
