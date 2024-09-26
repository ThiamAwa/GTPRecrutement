<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'rating',
        'collaboration',
        'delais',
        'commentaire',
        'mission_id',
        'consultant_id',
    ];

    // Relation avec Mission
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    // Relation avec Consultant
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
