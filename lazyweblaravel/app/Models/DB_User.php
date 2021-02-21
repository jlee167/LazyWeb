<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DB_User extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $database = 'lazyboyserver';
    protected $table = 'user';
    protected $primaryKey = 'uid';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
}
