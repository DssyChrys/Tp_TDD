<?php

  
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule', 'nom', 'prenom', 'niveau'
    ];

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id');
    }
    public function unites_enseignement()
    {
        return $this->belongsToMany(unites_enseignement::class, 'table_pivot');
    }

    public function ues()
    {
        return $this->hasMany(unites_enseignement::class);
    }

    public function moyenne()
    {
        if ($this->notes->isEmpty()) {
            return null; 
        }
        return $this->notes->avg('note');
    }

    public function calculerECTS()
    {
        $ects = $this->unites_enseignement->sum(function ($ue) {
            // Assurez-vous que les crédits ECTS sont bien calculés
            $validECTS = $ue->credits_ects; // Assurez-vous que `credits_ects` existe et est valide
            return $ue->moyenne() >= 10 ? $validECTS : 0;
        });
    
        dd($ects); // Debugger le total des ECTS
        return $ects;
    }
    



    public function validationSemestre()
    {
        // Vérifiez si les unités d'enseignement ont des notes associées
        if ($this->unites_enseignement->isEmpty()) {
            return false; // Ou une autre logique
        }
    
        // Calculer la moyenne du semestre à partir des unités d'enseignement
        $moyenneSemestre = $this->unites_enseignement->avg(function ($ue) {
            return $ue->moyenne(); // Cette méthode doit calculer la moyenne des notes d'une unité d'enseignement
        });
    
        return $moyenneSemestre >= 10;
    }
    




    public function passerAnneeSuivante()
    {
        return $this->validationSemestre() && $this->calculerECTS() >= 60;
    }


    }
