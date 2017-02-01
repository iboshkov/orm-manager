<?php

namespace App;

use App\Providers\ORMManager;
use App\Providers\ORMManagerSupport;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  use ORMManagerSupport;

  protected $fillable = ['id', 'nickname', 'longitude', 'latitude'];
  
    public function user() {
      return $this->belongsTo('App\User');
    }

  protected $relationships = ['user'];
}
