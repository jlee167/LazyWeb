<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebToken extends Model
{
    public $id;
    public $last_update;
    protected $fillable = [
        'stream_id',
        'uid',
        'token'
    ];

    protected $table = 'stream_webtokens';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
