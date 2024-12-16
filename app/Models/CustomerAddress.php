<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAddress extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'address' => 'N/A',
        ]);
    }
}
