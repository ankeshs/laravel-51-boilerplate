<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /* Alowing Eloquent to insert data into our database */
    protected $fillable = [
        'id', 
        'name'
    ];

    public $timestamps = true;
        
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';
        
    protected $primaryKey = 'id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
