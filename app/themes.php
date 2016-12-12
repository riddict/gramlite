<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class themes extends Model
{
    protected $table = 'themes';
	protected $primaryKey = 'id';
    public function User()
	{
		return $this->hasOne('App\User', 'themes');
	}
}
