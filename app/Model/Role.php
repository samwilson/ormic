<?php

namespace Amsys\Model;

class Role extends \Illuminate\Database\Eloquent\Model {

	public function users() {
		return $this->belongsToMany('Amsys\Model\User');
	}

}
