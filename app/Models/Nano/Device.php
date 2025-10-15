<?php

namespace App\Models\Nano;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'nano';

    protected $table = 'devices';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'identity_cert',
        'serial_number',
        'unlock_token',
        'unlock_token_at',
        'authenticate',
        'authenticate_at',
        'token_update',
        'token_update_at',
        'bootstrap_token_b64',
        'bootstrap_token_at',
    ];

    protected $casts = [
        'unlock_token_at' => 'datetime',
        'authenticate_at' => 'datetime',
        'token_update_at' => 'datetime',
        'bootstrap_token_at' => 'datetime',
    ];
}
