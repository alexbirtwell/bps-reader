<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAccumulativeFlowAttribute(): float
    {
        return $this->attributes['accumulative_flow'] > 0 ? ($this->attributes['accumulative_flow']  * 10) : 0;
    }

    public function getTemperatureAttribute(): float
    {
        return $this->attributes['temperature'] ? ($this->attributes['temperature'] / 10) : 0;
    }

     public function getPressureAttribute(): float
    {
        return $this->attributes['pressure']  ? ($this->attributes['pressure']  / 100) : 0;
    }
}
