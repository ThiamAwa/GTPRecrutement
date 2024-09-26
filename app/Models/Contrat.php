<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_contrat',
        'statut',
        'date_debut',
        'date_fin',
        'consultant_id',
        'mission_id',
        'client_id',
    ];
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
