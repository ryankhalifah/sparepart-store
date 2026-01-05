<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 
 
return new class extends Migration 
{ 
    public function up(): void 
    { 
        Schema::create('order_items', function (Blueprint $table) 
{ 
            $table->id(); 
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            $table->foreignId('sparepart_id')->constrained('spareparts')->onDelete('cascade'); 
            $table->integer('jumlah'); 
            $table->decimal('subtotal', 10, 2); 
            $table->timestamps(); 
        }); 
    } 
// ... 
};