<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'nastavnik_id',
        'naziv_rada',
        'naziv_rada_en',
        'zadatak_rada',
        'zadatak_rada_en',
        'tip_studija',
        'prihvaceni_student_id',
    ];

    public function nastavnik()
    {
        return $this->belongsTo(User::class, 'nastavnik_id');
    }

    public function prihvaceniStudent()
    {
        return $this->belongsTo(User::class, 'prihvaceni_student_id');
    }

    public function prijavljeniStudenti()
    {
        return $this->belongsToMany(User::class, 'task_applications', 'task_id', 'student_id')
            ->withPivot('prioritet')
            ->withTimestamps()
            ->orderBy('task_applications.prioritet');
    }
}
