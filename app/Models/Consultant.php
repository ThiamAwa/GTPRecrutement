<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;
     protected $fillable = [
         'telephone',
         'adresse',
         'competences',
         'experiences',
         'status',
         'date_disponibilite',
         'statut_evaluation',
         'notes_mission',
         'commentaires',
         'date_de_naissance',
         'cv'
     ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
