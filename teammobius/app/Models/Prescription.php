<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['medical_record_id','medication_name','dosage','instructions','quantity'];

    public function medicalRecord(){
        return $this->belongsTO(MedicalRecord::class);
    }
}
