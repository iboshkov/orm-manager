<?php

namespace App;

use App\Providers\ORMManager;
use App\Providers\ORMManagerSupport;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ORMManagerSupport;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {
        return $this->hasMany('App\Blog\Post', 'author_id');
    }

    public function profile() {
        return $this->hasOne('App\Profile');
    }

    public function groups() {
        return $this->belongsToMany('App\Group', 'groups_users', 'user_id', 'group_id');
    }

    protected $relationships = [
        "posts", "groups", "profile"
    ];
}
