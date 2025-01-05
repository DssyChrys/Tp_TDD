<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elements_constitutifs extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'nom', 'coefficient', 'ue_id'];

    public function unites_enseignement(){
        return $this->belongsTo(Unites_enseignement::class, 'ue_id', 'id');
    }
    
public function notes()
{
    return $this->hasMany(Note::class, 'ec_id');
}

}
