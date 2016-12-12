<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instagramAccount extends Model
{
	protected $table = 'instagram_account';
	protected $primaryKey = 'id';
    public function User()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
