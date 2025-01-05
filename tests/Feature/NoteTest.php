<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Etudiant;
use App\Models\unites_enseignement;
use App\Models\elements_constitutifs;
use App\Models\Note;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajout_note_valide()
    {
         
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1',   
        ]);
 
        $ec = elements_constitutifs::factory()->create();
        $note = Note::create([
            'etudiant_id' => $etudiant->id,
            'ec_id' => $ec->id,
            'note' => 15,
            'session' => 'normale',
        ]);

        $this->assertDatabaseHas('notes', [
            'note' => 15,
            'session' => 'normale',
        ]);
    }
    public function test_verification_limite_note()
    {
        $etudiant = Etudiant::create([
            'matricule' => '123457',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'niveau' => 'L2',
        ]);

        $response = $this->post(route('notes.store'), [
            'etudiant_id' => $etudiant->id,
            'note' => -5,
        ]);
        $response->assertSessionHasErrors('note');

        $response = $this->post(route('notes.store'), [
            'etudiant_id' => $etudiant->id,
            'note' => 25,
        ]);
        $response->assertSessionHasErrors('note');
    }




    public function test_calcul_moyenne()
{
    $etudiant = Etudiant::factory()->create();
    $ue = unites_enseignement::factory()->create();
    $ec = elements_Constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 3]);
    Note::factory()->create([
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 14,
        'session' => 'normale',
    ]);

    $this->assertGreaterThanOrEqual(10, $etudiant->moyenne());
}


    public function test_ajout_session_normale_et_rattrapage()
    {
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1'   
        ]);
        $ec = elements_constitutifs::factory()->create();

         
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 14, 'session' => 'rattrapage']);
        $this->assertCount(2, Note::where('etudiant_id', $etudiant->id)->where('ec_id', $ec->id)->get());
    }

    public function test_limite_deux_notes_par_ec_etudiant()
    {
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1'
        ]);
        
        $ec = elements_constitutifs::factory()->create();
        
        // Création de deux notes pour l'étudiant et l'élément constitutif
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 10, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 12, 'session' => 'normale']);
    
        // Vérifier que l'étudiant a bien deux notes pour cet élément constitutif
        $this->assertCount(2, Note::where('etudiant_id', $etudiant->id)->where('ec_id', $ec->id)->get());
    
        // Attendre qu'une exception soit lancée lorsqu'on essaie de créer une troisième note
        $this->expectException(\Exception::class);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 15, 'session' => 'normale']);
    }
    
    public function test_validation_ue_moyenne()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        $ue = unites_enseignement::factory()->create();
        $ec1 = elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 2]);
        $ec2 = elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $moyenne = $ue->moyenne($etudiant);  
        $this->assertGreaterThanOrEqual(10, $moyenne);
    }

    // Test de compensation entre UEs
    public function test_compensation_ue()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        // Première UE avec une moyenne < 10
        $ue1 = unites_enseignement::factory()->create();
        $ec1 = elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 8, 'session' => 'normale']);
        
        // Deuxième UE avec une moyenne > 10
        $ue2 = unites_enseignement::factory()->create();
        $ec2 = elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $totalMoyenne = $etudiant->moyenne();
        $this->assertGreaterThanOrEqual(10, $totalMoyenne);
    }

    // Test du calcul des ECTS acquis
    public function test_calcul_ects_acquis()
    {
        // Crée un étudiant
        $etudiant = Etudiant::factory()->create();
    
        // Crée des unités d'enseignement (UE) associées à l'étudiant via la table pivot
        $ue1 = unites_enseignement::factory()->create(['credits_ects' => 6]);
        $ue2 = unites_enseignement::factory()->create(['credits_ects' => 4]);
    
        // Associe l'étudiant à ces unités d'enseignement via la table pivot
        $etudiant->unites_enseignement()->attach([$ue1->id, $ue2->id]);
    
        // Crée les ECs (éléments constitutifs) et les associe aux unités d'enseignement
        $ec1 = elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        $ec2 = elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);
    
        // Crée des notes pour l'étudiant
        Note::factory()->create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 12]);
        Note::factory()->create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14]);
    
        // Calcul des ECTS acquis
        $ectsAcquis = $etudiant->calculerECTS();

        // Vérifie si les ECTS acquis sont corrects
        $this->assertEquals(10, $ectsAcquis); // 6 ECTS pour UE1 + 4 ECTS pour UE2
    }
    


    // Test de validation du semestre
    public function test_validation_semestre()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        $ue1 = unites_enseignement::factory()->create();
        $ue2 = unites_enseignement::factory()->create();

        $ec1 = elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        $ec2 = elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 15, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 12, 'session' => 'normale']);

        $validationSemestre = $etudiant->validationSemestre();
        $this->assertTrue($validationSemestre);  // Si la moyenne est supérieure ou égale à 10, le semestre est validé
    }

    // Test du passage à l'année suivante
    public function test_passage_annee_suivante()
    {
        $etudiant = Etudiant::factory()->create();
    
        // Créer des UEs avec des crédits et des moyennes valides
        $ue1 = unites_enseignement::factory()->create();
        $ue2 = unites_enseignement::factory()->create();
    
        // Associer les UEs à l'étudiant
        $etudiant->unites_enseignement()->attach([$ue1->id, $ue2->id]);
    
        // Créer des notes pour l'étudiant
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => 1, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => 2, 'note' => 14, 'session' => 'normale']);
    
        // Vérifier si l'étudiant passe à l'année suivante
        $passage = $etudiant->passerAnneeSuivante();
        dd($passage); // Debugger l'état de passage
    
        // Assurez-vous que l'étudiant passe à l'année suivante
        $this->assertTrue($passage);  // L'étudiant doit passer à l'année suivante si la moyenne et les ECTS sont validés
    }
    
    
    
    
}
