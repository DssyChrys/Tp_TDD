<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\elements_constitutifs ;
use Illuminate\Http\Request;


class NoteController extends Controller
{

    public function index()
    {
        $etudiants = Etudiant::with(['notes.ec'])->get();
        return view('notes.index', compact('etudiants'));
    }

  
    public function create()
    {
        $etudiants = Etudiant::all();
        $ecs = elements_constitutifs::all();
        return view('notes.create', compact('etudiants', 'ecs'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'ec_id' => 'required|exists:elements_constitutifs,id',
            'note' => 'required|numeric|min:0|max:20',
            'session' => 'required|in:normale,rattrapage',
        ]);

        Note::create([
            'etudiant_id' => $request->input('etudiant_id'),
            'ec_id' => $request->input('ec_id'),
            'note' => $request->input('note'),
            'session' => $request->input('session'),
            'date_evaluation' => now(),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès.');
    }

    
    public function edit(Note $note)
    {
       
        return view('notes.edit', compact('note'));
    }
   
    public function update(Request $request, Note $note)
    {
        
        $request->validate([
            'note' => 'required|numeric|min:0|max:20', 
        ]);

        $note->update([
            'note' => $request->note,
        ]);

        
        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès');
    }


    public function destroy(Note $note)
    {
        $note->delete();        
        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès');
    }
    
 
public function moyenne($etudiantId)
{
     
    $etudiant = Etudiant::find($etudiantId);

   
    if (!$etudiant) {
        return redirect()->route('notes.index')->with('error', 'Étudiant non trouvé');
    }
    $notes = $etudiant->notes()->with('ec')->get();

    if ($notes->isEmpty()) {
        return view('notes.moyenne', ['moyenne' => 0, 'etudiantId' => $etudiantId]);
    }

    $totalNotes = 0;
    $totalCoefficients = 0;

     
    foreach ($notes as $note) {
        $ec = $note->ec;  
        $totalNotes += $note->note * $ec->coefficient;
        $totalCoefficients += $ec->coefficient;
    }

     
    $moyenne = $totalCoefficients > 0 ? $totalNotes / $totalCoefficients : 0;

    return view('notes.moyenne', compact('moyenne', 'etudiantId'));
}




}
