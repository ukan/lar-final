<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'article_id', 'comment'];
    public $timestamps = true;

    public function article() {
		return $this->belongsTo('App\Models\Article');
	}
	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}
