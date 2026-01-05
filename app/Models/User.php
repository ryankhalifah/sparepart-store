<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import untuk tipe return relasi
// Pastikan baris ini di-uncomment/ditambahkan jika Anda menggunakan fitur 2FA
// use Laravel\Fortify\TwoFactorAuthenticatable; 
use App\Models\Order; // Import model Order agar metode orders() dikenali dengan baik

class User extends Authenticatable
{
    /** * @use HasFactory<\Database\Factories\UserFactory> 
     * @var array
     */
    // Jika Anda menggunakan TwoFactorAuthenticatable, pastikan untuk meng-uncomment baris di atas
    // dan menambahkan trait di bawah.
    use HasFactory, Notifiable; 
    // use HasFactory, Notifiable, TwoFactorAuthenticatable; 
      
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ 
        'name', 
        'email', 
        'password', 
        'role', // Tambahkan role 
    ]; 
      
    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany 
    { 
        return $this->hasMany(Order::class); 
    } 

    // ---

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // Jika menggunakan TwoFactorAuthenticatable, tambahkan ini:
        // 'two_factor_secret',
        // 'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Jika menggunakan TwoFactorAuthenticatable, tambahkan ini:
            // 'two_factor_confirmed_at' => 'datetime',
        ];
    }
}