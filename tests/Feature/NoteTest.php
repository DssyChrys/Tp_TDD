<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Etudiant;
use App\Models\Unites_enseignement;
use App\Models\Elements_constitutifs;
use App\Models\Note;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajout_note_valide()
    {
         
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1',   
        ]);
 
        $ec = Elements_constitutifs::factory()->create();
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




    public function test_calcul_moyenne_ue()
    {
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1'  
        ]);
        $ue = Unites_enseignement::factory()->create();
        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 2]);
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 10, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 15, 'session' => 'normale']);

        $moyenne = $ue->calculerMoyenne($etudiant);  
        $this->assertEquals(13, $moyenne);  
    }

    public function test_ajout_session_normale_et_rattrapage()
    {
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1'   
        ]);
        $ec = Elements_constitutifs::factory()->create();

         
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 14, 'session' => 'rattrapage']);
        $this->assertCount(2, Note::where('etudiant_id', $etudiant->id)->where('ec_id', $ec->id)->get());
    }

    public function test_limite_deux_notes_par_ec_etudiant()
    {
        $etudiant = Etudiant::factory()->create([
            'niveau' => 'L1'  
        ]);
        $ec = Elements_constitutifs::factory()->create();
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 10, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 12, 'session' => 'normale']);

        $this->assertCount(2, Note::where('etudiant_id', $etudiant->id)->where('ec_id', $ec->id)->get());
        $this->expectException(\Exception::class);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec->id, 'note' => 15, 'session' => 'normale']);
    }
    public function test_validation_ue_moyenne()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        $ue = Unites_enseignement::factory()->create();
        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 2]);
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $moyenne = $ue->calculerMoyenne($etudiant);  
        $this->assertGreaterThanOrEqual(10, $moyenne);
    }

    // Test de compensation entre UEs
    public function test_compensation_ue()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        // Première UE avec une moyenne < 10
        $ue1 = Unites_enseignement::factory()->create();
        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 8, 'session' => 'normale']);
        
        // Deuxième UE avec une moyenne > 10
        $ue2 = Unites_enseignement::factory()->create();
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $totalMoyenne = $etudiant->calculerMoyenneGlobale();
        $this->assertGreaterThanOrEqual(10, $totalMoyenne);
    }

    // Test du calcul des ECTS acquis
    public function test_calcul_ects_acquis()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        $ue1 = Unites_enseignement::factory()->create(['credits_ects' => 6]);
        $ue2 = Unites_enseignement::factory()->create(['credits_ects' => 4]);

        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $ectsAcquis = $etudiant->calculerECTS();
        $this->assertEquals(10, $ectsAcquis);  // 6 ECTS pour UE1 + 4 ECTS pour UE2
    }

    // Test de validation du semestre
    public function test_validation_semestre()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        $ue1 = Unites_enseignement::factory()->create();
        $ue2 = Unites_enseignement::factory()->create();

        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 15, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 12, 'session' => 'normale']);

        $validationSemestre = $etudiant->validationSemestre();
        $this->assertTrue($validationSemestre);  // Si la moyenne est supérieure ou égale à 10, le semestre est validé
    }

    // Test du passage à l'année suivante
    public function test_passage_annee_suivante()
    {
        $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);
        
        $ue1 = Unites_enseignement::factory()->create(['credits_ects' => 6]);
        $ue2 = Unites_enseignement::factory()->create(['credits_ects' => 4]);

        $ec1 = Elements_constitutifs::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
        $ec2 = Elements_constitutifs::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec1->id, 'note' => 12, 'session' => 'normale']);
        Note::create(['etudiant_id' => $etudiant->id, 'ec_id' => $ec2->id, 'note' => 14, 'session' => 'normale']);

        $passage = $etudiant->passerAnneeSuivante();  // Vérifier si l'étudiant a validé les ECTS et les semestres
        $this->assertTrue($passage);  // L'étudiant doit passer à l'année suivante si la moyenne et les ECTS sont validés
    }
    
    
}
