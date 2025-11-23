<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'qualifications',
        'experience_years',
        'bio',
        'image',
        'rating',
        'reviews_count',
        'is_active'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'experience_years' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Get the user account associated with the doctor
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the availabilities for the doctor
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the appointments for the doctor
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope a query to only include active doctors
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include doctors of a specific specialty
     */
    public function scopeBySpecialty($query, $specialty)
    {
        return $query->where('specialty', $specialty);
    }

    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots($date)
    {
        return $this->availabilities()
                    ->where('date', $date)
                    ->where('is_available', true)
                    ->orderBy('start_time')
                    ->get();
    }
}
