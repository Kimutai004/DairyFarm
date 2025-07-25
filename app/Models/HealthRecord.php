<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cattle_id',
        'checkup_date',
        'record_type',
        'veterinarian',
        'symptoms',
        'diagnosis',
        'treatment',
        'medication',
        'cost',
        'next_checkup_date',
        'notes',
    ];

    protected $casts = [
        'checkup_date' => 'date',
        'next_checkup_date' => 'date',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the user who owns this record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cattle this health record belongs to
     */
    public function cattle()
    {
        return $this->belongsTo(Cattle::class);
    }

    /**
     * Check if next checkup is due
     */
    public function isCheckupDue()
    {
        return $this->next_checkup_date && 
               $this->next_checkup_date <= now()->toDateString();
    }
}
