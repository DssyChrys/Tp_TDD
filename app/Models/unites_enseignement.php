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
}
