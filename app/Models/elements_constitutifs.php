<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elements_constitutifs extends Model
{
    use HasFactory;

    public function unites_enseignement(){
        return $this->belongsTo(unites_enseignement::class, 'ue_id', 'id');
    }
    
public function notes()
{
    return $this->hasMany(Note::class);   
}

}
