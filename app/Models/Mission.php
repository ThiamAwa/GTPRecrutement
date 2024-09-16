<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'status',
        'type_profil_recherche',
        'competences_requises',
        'niveau_experience',
        'duree',
        'objectifs',
        'consultant_id',
        'client_id',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
