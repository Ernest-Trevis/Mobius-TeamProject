<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','user_id','visit_date','symptoms','diagnosis','treatment'];
    protected $casts = ['visit_date'=>'date'];

    public function patient(){
        return $this->belongsTO(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }
}
