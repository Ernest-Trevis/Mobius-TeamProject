<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','first_name','last_name','date_of_birth','gender','phone','address'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function appointments(){
        return $this->hasMany(Appointments::class);
    }

    public function medicalRecords(){
        return $this->hasMany(MedicalRecord::class);
    }
}