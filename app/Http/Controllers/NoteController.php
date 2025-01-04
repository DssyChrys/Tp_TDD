<?php
namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\elements_constitutifs;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with('notes')->get();
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
        // Validation des données d'entrée
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'ec_id' => 'required|exists:elements_constitutifs,id',
            'note' => 'required|numeric|min:0|max:20',
            'session' => 'required|in:normale,rattrapage',
        ]);
    
        // Vérifier si l'étudiant a déjà 2 notes pour cette matière (EC)
        $notesExistantes = Note::where('etudiant_id', $request->etudiant_id)
            ->where('ec_id', $request->ec_id)
            ->count();
    
        if ($notesExistantes >= 2) {
            return redirect()->back()->with('error', 'L\'étudiant a déjà 2 notes pour cette matière.');
        }
    
        // Déterminer si la note ajoutée est pour le Contrôle Continu ou Contrôle Terminal
        $session = $request->session;
        $note = new Note();
        $note->etudiant_id = $request->etudiant_id;
        $note->ec_id = $request->ec_id;
        $note->note = $request->note;
        $note->session = $session;
        $note->date_evaluation = now();
    
        // Ajouter la note
        $note->save();
    
        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès.');
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'ec_id' => 'required|exists:elements_constitutifs,id',
            'note' => 'required|numeric|min:0|max:20',
            'session' => 'required|string|in:normale,rattrapage',
        ]);
    
        $note = Note::findOrFail($id);
    
        $note->update([
            'etudiant_id' => $request->input('etudiant_id'),
            'ec_id' => $request->input('ec_id'),
            'note' => $request->input('note'),
            'session' => $request->input('session'),
        ]);
    
        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès.');
    }
    
public function edit($id)
{
    // Récupérer la note par son identifiant
    $note = Note::findOrFail($id);
    
    // Récupérer les éléments constitutifs pour la liste déroulante
    $ecs = elements_constitutifs::all();
    
    // Récupérer les étudiants pour la liste déroulante
    $etudiants = Etudiant::all();

    return view('notes.edit', compact('note', 'ecs', 'etudiants'));
}

public function destroy(Note $note)
{
    // Supprimer la note
    $note->delete();

    // Retourner à la liste des notes avec un message de succès
    return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès');
}
public function moyenne($etudiantId)
{
    // Récupérer l'étudiant
    $etudiant = Etudiant::find($etudiantId);
    
    if (!$etudiant) {
        return redirect()->route('notes.index')->with('error', 'Étudiant non trouvé');
    }

    // Récupérer toutes les notes de l'étudiant, y compris les éléments constitutifs associés
    $notes = Note::with('ec')->where('etudiant_id', $etudiantId)->get();

    if ($notes->isEmpty()) {
        return view('notes.moyenne', ['notes' => $notes, 'moyenne' => 0, 'etudiantId' => $etudiantId]);
    }

    // Variables pour le calcul de la moyenne pondérée
    $totalNotes = 0;
    $totalCoefficients = 0;

    // Variables pour le stockage des notes CC et CT
    $controleContinue = [];
    $controleTerminal = [];

    // Parcours des notes et classification par type de contrôle
    foreach ($notes as $note) {
        $ec = $note->ec;
        if ($ec) {
            if ($note->session == 'normale') {
                $controleContinue[] = $note; // Ajouter à CC si session normale
            } else {
                $controleTerminal[] = $note; // Ajouter à CT si session de rattrapage
            }
            
            // Calcul de la moyenne pondérée
            $totalNotes += $note->note * $ec->coefficient;
            $totalCoefficients += $ec->coefficient;
        }
    }

    // Calcul de la moyenne pondérée
    $moyenne = $totalCoefficients > 0 ? $totalNotes / $totalCoefficients : 0;

    // Passer les données à la vue
    return view('notes.moyenne', [
        'notes' => $notes,
        'moyenne' => $moyenne,
        'etudiantId' => $etudiantId,
        'controleContinue' => $controleContinue,
        'controleTerminal' => $controleTerminal
    ]);
}

}
