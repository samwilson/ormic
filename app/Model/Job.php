<?php

namespace Amsys\Model;

class Job extends \Illuminate\Database\Eloquent\Model {

	const STATUS_OPEN = 10;

	public function status() {
		return self::STATUS_OPEN;
	}

	public function jobType() {
		return $this->belongsTo('Amsys\Model\JobType');
	}

	public function asset() {
		return $this->belongsTo('Amsys\Model\Asset');
	}

	public function tasks() {
		return $this->hasMany('Amsys\Model\Task');
	}

//	public function saved() {
//		// Create the first Task.
//		$task = $this->jobType->initialTaskType;
//	}
}
