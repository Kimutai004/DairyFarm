<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cattle_id',
        'production_date',
        'morning_milk',
        'evening_milk',
        'fat_content',
        'protein_content',
        'notes',
    ];

    protected $casts = [
        'production_date' => 'date',
        'morning_milk' => 'decimal:2',
        'evening_milk' => 'decimal:2',
        'total_milk' => 'decimal:2',
        'fat_content' => 'decimal:2',
        'protein_content' => 'decimal:2',
    ];

    /**
     * Get the user who owns this record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cattle this production belongs to
     */
    public function cattle()
    {
        return $this->belongsTo(Cattle::class);
    }

    /**
     * Get total milk production (computed column)
     */
    public function getTotalMilkAttribute()
    {
        return $this->morning_milk + $this->evening_milk;
    }
}
