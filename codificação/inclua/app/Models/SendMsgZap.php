<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMsgZap extends Model
{
    use HasFactory;
    protected $fillable = [
        'msg','phone','instance','enviado'
    ];
    protected $table='msg_send_zap';
}
