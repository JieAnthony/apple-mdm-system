<?php

namespace App\Models\Nano;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $connection = 'nano';

    protected $table = 'commands';

    protected $primaryKey = 'command_uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'command_uuid',
        'request_type',
        'command',
    ];
}
