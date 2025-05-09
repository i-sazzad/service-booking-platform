<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Service;

class Booking extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'customer_name',
        'phone',
        'service_id',
        'status',
        'scheduled_at'
    ];

    // A booking belongs to a service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
