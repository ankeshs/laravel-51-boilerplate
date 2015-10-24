<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailLogin extends Model
{
    protected $fillable = ['email'];

    protected $table = 'email_logins';
        
    protected $primaryKey = 'email';
        
    public $timestamps = true;
    
}
