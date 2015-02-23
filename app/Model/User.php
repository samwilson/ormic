<?php

namespace Amsys\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;

	public function roles() {
		return $this->belongsToMany('Amsys\Model\Role');
	}

	public function setUsernameAttribute($value) {
		$this->attributes['username'] = $value;
		if (empty($this->attributes['name'])) {
			$this->attributes['name'] = $value;
		}
	}

}
