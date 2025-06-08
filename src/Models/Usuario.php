<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'sec_users';
    public $timestamps = false;

    protected $fillable = ['login', 'pswd', 'name', 'email', 'active'];
}
