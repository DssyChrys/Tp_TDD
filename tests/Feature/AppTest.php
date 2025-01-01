<?php

namespace Tests\Feature;

use App\Models\elements_constitutifs;
use App\Models\unites_enseignement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppTest extends TestCase
{
    //Test des UEs
    public function test_creation_dune_UE(){
        $data=[
            'code'=>'UE13',
            'nom'=>'electronique',
            'credits_ects'=>'4',
            'semestre'=>'4'
        ];

        $response= $this->post(route('Ue.store'), $data);
        $this->assertDatabaseHas('unites_enseignement',$data);  
    } 
    /*public function test_validation_des_credits_entre_1_et_30(): void
    {
        $data=[
            'code'=>'UE14',
            'nom'=>'bureautique',
            'credits_ects'=>'32',
            'semestre'=>'4'
        ];

        $response= $this->post(route('Ue.store'), $data);
        $this->assertDatabaseHas('unites_enseignement',$data);  
    }*/

    public function test_association_ec_a_une_ue()
    {
        $ue = unites_enseignement::factory()->create();
        elements_constitutifs::factory(3)->create(['ue_id' => $ue->id]);

        $this->assertCount(3, $ue->elements_constitutifs);
    }

    public function test_validation_format_du_code()
    {
    $data = [
        'code' => '123UE', // Format invalide
        'nom' => 'Physique',
        'credits_ects' => '6',
        'semestre' => '2'
    ];

    $response = $this->postJson(route('Ue.store'), $data);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['code']);
    $this->assertStringContainsString('The code field format is invalid', $response->json('errors.code')[0]);
    }
    public function test_validation_du_semestre()
    {
    $data = [
        'code' => 'UE20', 
        'nom' => 'Chimie',
        'credits_ects' => '6',
        'semestre' => '8'
    ];

    $response = $this->postJson(route('Ue.store'), $data);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['semestre']);
    $this->assertStringContainsString('The semestre field must not be greater than 6', $response->json('errors.semestre')[0]);
    }


    //Test des Ecs
    public function test_creation_dune_EC_avec_coefficient_valide()
    {
    $ue = unites_enseignement::factory()->create();

    $data = [
        'code' => 'EC01',
        'nom' => 'Programmation',
        'coefficient' => 3,
        'ue_id' => $ue->id,
    ];

    $response = $this->post('/storeEc', $data);

    $response->assertStatus(302)
             ->assertSessionHas('message', 'EC créé avec succès');

    $this->assertDatabaseHas('elements_constitutifs', $data);
    }

    public function test_ec_rattaché_a_ue()
    {
    $data = [
        'code' => 'EC02',
        'nom' => 'Bases de données',
        'coefficient' => 2,
        'ue_id' => 999, // UE inexistante
    ];

    $response = $this->post('/storeEc', $data);

    $response->assertStatus(302);
    $response->assertSessionHasErrors(['ue_id']);
    }
    public function test_mise_a_jour_ec()
    {
    $ue = unites_enseignement::factory()->create();

    $ec = elements_constitutifs::factory()->create([
        'code' => 'EC01',
        'nom' => 'Ancien Nom',
        'coefficient' => 2,
        'ue_id' => $ue->id,
    ]);
    $data = ['code' => 'EC01',
            'nom' => 'Nouveau Nom',
            'coefficient' => 2,
            'ue_id' => $ue->id,];

    $response = $this->put(route('Ec.update', ['id' => $ec->id]), $data);

    $response->assertStatus(302) 
             ->assertSessionHas('message', 'EC mis a jour avec succès');

    $this->assertDatabaseHas('elements_constitutifs', $data);
    }
    public function test_suppression_ec()
    {
    $ec = elements_constitutifs::factory()->create();

    $response = $this->delete(route('Ec.delete', $ec->id));

    $response->assertStatus(302)
             ->assertSessionHas('message','EC supprimer avec succès');

    $this->assertDatabaseMissing('elements_constitutifs', ['id' => $ec->id]);
    }

}
