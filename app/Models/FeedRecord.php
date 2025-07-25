<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cattle_id',
        'feeding_date',
        'feed_type',
        'quantity',
        'cost_per_unit',
        'total_cost',
        'notes',
    ];

    protected $casts = [
        'feeding_date' => 'date',
        'quantity' => 'decimal:2',
        'cost_per_unit' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    /**
     * Get the user who owns this record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cattle this feed record belongs to (nullable)
     */
    public function cattle()
    {
        return $this->belongsTo(Cattle::class);
    }

    /**
     * Calculate total cost automatically
     */
    public function calculateTotalCost()
    {
        if ($this->quantity && $this->cost_per_unit) {
            return $this->quantity * $this->cost_per_unit;
        }
        return $this->total_cost;
    }
}
