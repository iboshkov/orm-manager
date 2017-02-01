<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Providers\ORMManager;
use App\Providers\ORMManagerSupport;

class Group extends Model
{
    use ORMManagerSupport;
    protected $fillable = [
        'id', 'name', 'allowed_from', 'allowed_to'
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'groups_users', 'group_id', 'user_id');
    }

    protected $relationships = ['users']; 
}
