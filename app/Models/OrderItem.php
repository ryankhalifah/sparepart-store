<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// ... 
 
class OrderItem extends Model 
{ 
    // ... 
    protected $fillable = ['order_id', 'sparepart_id', 'jumlah', 'subtotal']; 
     
    public function sparepart(): BelongsTo 
    { 
        return $this->belongsTo(Sparepart::class); 
    } 
     
    public function order(): BelongsTo 
    { 
        return $this->belongsTo(Order::class); 
    } 
} 
 