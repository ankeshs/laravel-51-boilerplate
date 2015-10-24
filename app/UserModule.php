<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    /* Alowing Eloquent to insert data into our database */
    protected $fillable = ['id', 'user_id', 'module_id', 'status'];

    public $timestamps = true;
        
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_modules';

    protected $primaryKey = 'id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
