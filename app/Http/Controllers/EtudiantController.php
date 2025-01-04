<?php
namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\elements_constitutifs;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::all();
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'matricule' => 'required|unique:etudiants,matricule', 
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'niveau' => 'required|in:L1,L2,L3',
        ]);

        
        Etudiant::create([
            'matricule' => $request->matricule,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'niveau' => $request->niveau,
        ]);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant ajouté avec succès');
    }



public function update(Request $request, $id)
{
    
    $request->validate([
        'numero_etudiant' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'niveau' => 'required|in:L1,L2,L3',
    ]);

 
    $etudiant = Etudiant::findOrFail($id);
    $etudiant->update($request->all());
    return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour avec succès');
}

    public function delete($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('message', 'Étudiant supprimé avec succès');
    }

   
    public function createNote()
    {
        $etudiants = Etudiant::all();
        $ecs = elements_constitutifs::all();  
        return view('notes.create', compact('etudiants', 'ecs'));
    }

    public function destroy($id)
    
{
    $etudiant = Etudiant::findOrFail($id);
    $etudiant->delete();
    return redirect()->route('etudiants.index')->with('message', 'Étudiant supprimé avec succès');
}

public function edit($id)
{
    
    $etudiant = Etudiant::findOrFail($id);
    return view('etudiants.edit', compact('etudiant'));
}


}
