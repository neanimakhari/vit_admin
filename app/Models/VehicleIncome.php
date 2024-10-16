<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VehicleIncome extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'vehicleincome'; // Make sure this matches your actual table name

    protected $fillable = [
        'starting_km',
        'end_km',
        'income',
        'petrol_poured',
        'petrol_litres',
        'logged_on',
        'vehicle',
        'driver_id',
        'driver_name',
        'expense_detail',
        'expense_price',
        'expense_image',
        'petrol_slip',
    ];

    protected $dates = ['logged_on'];

    public function getLoggedOnAttribute($value)
    {
        if (!$value || $value === 'string') {
            return null;
        }
        if (is_string($value)) {
            try {
                return Carbon::parse($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return $value;
    }
}
