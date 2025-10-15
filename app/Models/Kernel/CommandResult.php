<?php

namespace App\Models\Kernel;

use Illuminate\Database\Eloquent\Model;

class CommandResult extends Model
{
    protected $connection = 'nano';

    protected $table = 'command_results';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'command_uuid',
        'status',
        'result',
        'not_now_at',
        'not_now_tally',
    ];
}
