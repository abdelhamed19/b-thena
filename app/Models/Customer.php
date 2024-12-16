<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function addresses()
    {
        return $this->hasOne(CustomerAddress::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function getOrdersCountAttribute()
    {
        return $this->orders->count();
    }
    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->user_id = auth()->id();
        });
    }
}
