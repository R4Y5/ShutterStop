<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'email',
        'status',
        'total',
        'address',
        'remarks',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recalcTotal()
    {
        $this->total = $this->items->sum(fn($item) => $item->price * $item->quantity);
        $this->save();
    }

}
