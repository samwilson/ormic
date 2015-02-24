<?php

namespace Ormic\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Base implements AuthenticatableContract {

	use Authenticatable;

	public function roles() {
		return $this->belongsToMany('Ormic\Model\Role');
	}

	public function setUsernameAttribute($value) {
		$this->attributes['username'] = $value;
		if (empty($this->attributes['name'])) {
			$this->attributes['name'] = $value;
		}
	}

}
