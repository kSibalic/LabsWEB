<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'naziv',
        'opis',
        'cijena',
        'obavljeni_poslovi',
        'datum_pocetka',
        'datum_zavrsetka',
    ];

    protected $casts = [
        'datum_pocetka' => 'date',
        'datum_zavrsetka' => 'date',
        'cijena' => 'decimal:2',
    ];

    public function voditelj()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clanovi()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}

