<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unites_enseignement extends Model
{
    use HasFactory;
    protected $table = 'unites_enseignement';

    public function elements_constitutifs(){
        return $this->hasMany(elements_constitutifs::class, 'ue_id', 'id');
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            if($model->credit > 30){
                throw new \InvalidArgumentException('le nombre de credit ne peut pas depassser 30');
            }
        });
    }
}
