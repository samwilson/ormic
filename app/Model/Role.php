<?php

namespace Ormic\Model;

class Role extends \Illuminate\Database\Eloquent\Model {

	public function users() {
		return $this->belongsToMany('Ormic\Model\User');
	}

}
