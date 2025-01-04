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
}
