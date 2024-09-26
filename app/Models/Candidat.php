<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'adresse',
        'status',
        'telephone',
        'date_de_candidature',
        'date_de_naissance',
        'lm',
        'cv',
        'competences',
        'experience',
        'offre_id',

    ];

    public function offre()
    {
        return $this->belongsTo(Offre::class, 'offre_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
