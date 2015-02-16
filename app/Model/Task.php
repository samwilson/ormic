<?php

namespace Amsys\Model;

class Task extends \Illuminate\Database\Eloquent\Model {

	const STATUS_OPEN = 10;

	public function status() {
		return self::STATUS_OPEN;
	}

	public function job() {
		return $this->belongsTo('Job');
	}

}
