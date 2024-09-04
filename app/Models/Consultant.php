<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;
     protected $fillable = [
         'nom',
         'prenom',
         'email',
         'adresse',
         'competences',
         'experiences',
         'status',
         'date_disponibilite',
         'statut_evaluation',
         'contrat',
         'notes_mission',
         'commentaires',
         'date_de_naissance',
         'missions_attribuees',
         'cv'
     ];

}
