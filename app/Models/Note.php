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

