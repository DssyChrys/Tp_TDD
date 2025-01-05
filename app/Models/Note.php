<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'ec_id',
        'note',
        'session',
        'date_evaluation',
    ];

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($note) {
            $existingNotesCount = Note::where('etudiant_id', $note->etudiant_id)
                                      ->where('ec_id', $note->ec_id)
                                      ->count();
            
            if ($existingNotesCount >= 2) {
                throw new \Exception("Un étudiant ne peut avoir que deux notes par élément constitutif.");
            }
        });
    }
    public function unites_enseignement()
    {
        return $this->belongsToMany(unites_enseignement::class, 'table_pivot', 'note_id', 'unites_enseignement_id');
    }

public function etudiant()
{
    return $this->belongsTo(Etudiant::class, 'etudiant_id');
}

public function ec()
{
    return $this->belongsTo(elements_constitutifs::class, 'ec_id');
}
public static $rules = [
    'note' => 'required|numeric|min:0|max:20',
];

}

