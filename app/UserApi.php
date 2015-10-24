<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApi extends Model
{
    /* Alowing Eloquent to insert data into our database */
    protected $fillable = ['user_id', 'user_api_key'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_apis';
        
    protected $primaryKey = 'user_id';
        
    public $timestamps = true;
        
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_api_key'];
        
    public function user() {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}
