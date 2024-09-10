<?php

namespace App\Models;

use App\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientModel extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'name',
        'birth_date',
        'place_of_birth',
        'gender',
        'address',
    ];

    // Only encrypt sensitive fields
    protected $encryptable = [
        'name',
        'birth_date',
        'place_of_birth',
        'address',
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecordModel::class);
    }
}
