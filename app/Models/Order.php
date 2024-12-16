<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => 'N/A',
            'phone_number' => 'N/A',
            'address' => 'N/A',
        ]);
    }
    public function items()
    {
        return $this->hasMany(OrderItems::class)->with('menu');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . rand(100000, 999999);
        });
    }
    public function getOrderTypeAttribute($value)
    {
        return $value == 'take_away' ? 'إستلام من الفرع' : 'توصيل للمنزل';
    }
}
