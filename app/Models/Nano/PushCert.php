<?php

namespace App\Models\Nano;

use Illuminate\Database\Eloquent\Model;

class PushCert extends Model
{
    protected $connection = 'nano';

    protected $table = 'push_certs';

    protected $primaryKey = 'topic';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'topic',
        'cert_pem',
        'key_pem',
        'stale_token',
    ];
}
