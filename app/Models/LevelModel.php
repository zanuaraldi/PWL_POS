<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;
    
    protected $table = 'm_level'; // Mendefinisikan nama tabel
    protected $primaryKey = 'level_id'; // Mendefinisikan primary key

    protected $fillable = ['level_kode', 'level_nama'];

    // Relasi ke UserModel (hasMany)
    public function users(): HasMany {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
