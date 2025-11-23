<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'scheduled_at',
        'reason',
        'notes',
        'status',
        'cancelled_at',
        'cancellation_reason'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    /**
     * Appointment status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    /**
     * Get the patient that owns the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that owns the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>=', now())
                    ->whereNotIn('status', [self::STATUS_CANCELLED, self::STATUS_COMPLETED]);
    }

    /**
     * Scope a query to only include appointments for a specific patient.
     */
    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope a query to only include appointments for a specific doctor.
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope a query to only include pending appointments.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include confirmed appointments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Check if the appointment can be cancelled.
     */
    public function canBeCancelled()
    {
        if ($this->status === self::STATUS_CANCELLED) {
            return false;
        }

        return $this->scheduled_at->diffInHours(now(), false) >= 24;
    }

    /**
     * Cancel the appointment.
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason
        ]);
    }

    /**
     * Confirm the appointment.
     */
    public function confirm()
    {
        $this->update(['status' => self::STATUS_CONFIRMED]);
    }

    /**
     * Mark the appointment as completed.
     */
    public function complete()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }

    /**
     * Get formatted scheduled date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->scheduled_at->format('F j, Y');
    }

    /**
     * Get formatted scheduled time.
     */
    public function getFormattedTimeAttribute()
    {
        return $this->scheduled_at->format('h:i A');
    }

    /**
     * Check if appointment is upcoming.
     */
    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_at->isFuture() && $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Check if appointment is pending.
     */
    public function getIsPendingAttribute()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if appointment is cancelled.
     */
    public function getIsCancelledAttribute()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if appointment is completed.
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
