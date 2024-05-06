<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    protected $primaryKey = 'email';
    public $incrementing = false;

    protected $fillable = [
        'email','token','created_at'
    ];
    protected $table='password_resets';
    public $timestamps=false;
}
