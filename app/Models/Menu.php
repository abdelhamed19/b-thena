<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'item_name',
        'item_description',
        'item_price',
        'is_active',
    ];
    const ACTIVE = 1;
    const INACTIVE = 0;
    public function getActiveStatusAttribute()
    {
       return $this->is_active == 1 ? 'نشط' : 'غير نشط';
    }
}
