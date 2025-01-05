<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unites_enseignement extends Model
{
    use HasFactory;
    protected $table = 'unites_enseignement';
    protected $fillable = [ 'credits_ects']; 

    public function elements_constitutifs(){
        return $this->hasMany(elements_constitutifs::class, 'ue_id', 'id');
    }
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'table_pivot');
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            if($model->credit > 30){
                throw new \InvalidArgumentException('le nombre de credit ne peut pas depassser 30');
            }
        });
    }
    

public function moyenne()
{
    
    return $this->notes()->avg('note');
}
 

public function notes()
{
    return $this->hasMany(Note::class);  
}


}
