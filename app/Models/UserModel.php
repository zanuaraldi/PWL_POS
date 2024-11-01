<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';        // Mendefinisikan nama table yang digunakan oleh model ini 
    protected $primaryKey = 'user_id';  // Mendefinisikan Primary Key dari table yang digunakan

    protected $fillable = ['level_id','profile_image', 'username', 'nama', 'password', 'created_at', 'updated_at'];

    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    // Relasi ke tabel level
    public function level(): BelongsTo{
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // Menadapatkan nama role
    public function getRoleName(): string {
        return $this->level->level_nama;
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role): bool {
        return $this->level->level_kode == $role;
    }

    // Mendapatkan kode role
    public function getRole(){
        return $this->level->level_kode;
    }

    public function stok(): HasMany {
        return $this->hasMany(StokModel::class, 'user_id', 'user_id');
    }

    public function penjualan(): HasMany {
        return $this->hasMany(PenjualanModel::class, 'user_id', 'user_id');
    }
}
