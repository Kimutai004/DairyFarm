<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cattle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag_number',
        'name',
        'breed',
        'gender',
        'date_of_birth',
        'weight',
        'status',
        'color',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'weight' => 'decimal:2',
    ];

    /**
     * Get the owner of the cattle
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get milk production records
     */
    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class);
    }

    /**
     * Get breeding records
     */
    public function breedingRecords()
    {
        return $this->hasMany(BreedingRecord::class);
    }

    /**
     * Get health records
     */
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    /**
     * Get feed records
     */
    public function feedRecords()
    {
        return $this->hasMany(FeedRecord::class);
    }

    /**
     * Get age in years
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    /**
     * Get latest milk production
     */
    public function getLatestMilkProductionAttribute()
    {
        return $this->milkProductions()->latest('production_date')->first();
    }

    /**
     * Get total milk production for current month
     */
    public function getCurrentMonthMilkTotal()
    {
        return $this->milkProductions()
            ->whereYear('production_date', now()->year)
            ->whereMonth('production_date', now()->month)
            ->sum('total_milk');
    }

    /**
     * Check if cattle is female and can produce milk
     */
    public function canProduceMilk()
    {
        return $this->gender === 'female' && $this->status === 'active';
    }
}
