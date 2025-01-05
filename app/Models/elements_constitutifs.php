<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elements_constitutifs extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'nom', 'coefficient', 'ue_id'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->credits_ects > 30) {
                throw new \Exception("Le nombre de crédits ne peut pas dépasser 30.");
            }
        });
    }
    public function unites_enseignement(){
        return $this->belongsTo(unites_enseignement::class, 'ue_id', 'id');
    }
    
public function notes()
{
    return $this->hasMany(Note::class, 'ec_id');
}

}
