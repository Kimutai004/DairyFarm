<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BreedingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cattle_id',
        'breeding_date',
        'breeding_method',
        'sire_info',
        'expected_calving_date',
        'actual_calving_date',
        'pregnancy_status',
        'gestation_period',
        'notes',
    ];

    protected $casts = [
        'breeding_date' => 'date',
        'expected_calving_date' => 'date',
        'actual_calving_date' => 'date',
    ];

    /**
     * Get the user who owns this record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cattle this breeding record belongs to
     */
    public function cattle()
    {
        return $this->belongsTo(Cattle::class);
    }

    /**
     * Calculate expected calving date (average 283 days gestation)
     */
    public function calculateExpectedCalvingDate()
    {
        return $this->breeding_date ? 
            Carbon::parse($this->breeding_date)->addDays(283) : null;
    }

    /**
     * Get days remaining until expected calving
     */
    public function getDaysToCalvingAttribute()
    {
        if (!$this->expected_calving_date) {
            return null;
        }
        
        $today = Carbon::today();
        $calvingDate = Carbon::parse($this->expected_calving_date);
        
        return $today->diffInDays($calvingDate, false);
    }
}
