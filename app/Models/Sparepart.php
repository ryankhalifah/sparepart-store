<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'harga',
        'stok',
        'gambar',
        'diskon'
    ];

    /** 
     * Accessor: Menghitung harga setelah diskon. 
     * Digunakan sebagai $sparepart->harga_setelah_diskon. 
     */
    protected function hargaSetelahDiskon(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['diskon'] > 0) {
                    return $attributes['harga'] -
                        ($attributes['harga'] * $attributes['diskon'] / 100);
                }
                return $attributes['harga'];
            },
        );
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('jumlah', 'subtotal');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function (
            $query,
            $search
        ) {
            $query->where('nama', 'like', '%' . $search . '%')->orWhere('kode', 'like', '%' . $search . '%');
        });
        $query->when($filters['category'] ?? false, function (
            $query,
            $category
        ) {
            $query->where('kategori', $category);
        });
    }
}
