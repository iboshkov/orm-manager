<?php

namespace App\Blog;

use App\Providers\ORMManagerSupport;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use ORMManagerSupport;
    protected $table = 'posts';

    protected $fillable = ["title"];

    public function user() {
        return $this->belongsTo('App\User');
    }

    protected $relationships = ["user"];

}
