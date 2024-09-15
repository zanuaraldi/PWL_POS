<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';        // Mendefinisikan nama table yang digunakan oleh model ini 
    protected $primaryKey = 'user_id';  // Mendefinisikan Primary Key dari table yang digunakan
}
