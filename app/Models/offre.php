<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offre extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'competences',
        'experience',
        'lieu',
        'type_contrat',
        'date_debut',
        'client_id',


    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function candidats()
    {
        return $this->hasMany(Candidat::class, 'offre_id');
    }
}
