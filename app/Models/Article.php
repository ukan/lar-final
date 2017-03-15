<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'content', 'writer'];
    public $timestamps = true;

    public function comments() {
    	return $this->hasMany('App\Models\Comment');
  	}
  	
  	/*public function getUsersComment(){
  		$users = DB::table('articles')
            ->join('comments', 'articles.id', '=', 'comments.article_id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('articles.content','comments.comment','users.username')
            ->get();
  	}*/
}