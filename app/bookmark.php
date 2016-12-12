<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bookmark extends Model
{
    protected $table = 'bookmark';
	protected $primaryKey = 'id';
    public function User()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
