<?php

namespace Amsys\Model;

class JobType extends \Illuminate\Database\Eloquent\Model {

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		self::saving(array($this, 'onSaving'));
	}

	public function parentType() {
		return $this->belongsTo('Amsys\Model\JobType');
	}

	public function childredTypes() {
		return $this->hasMany('Amsys\Model\JobType');
	}

	public function jobs() {
		return $this->hasMany('Amsys\Model\Job');
	}

	public static function onSaving($jobType) {
		// If this is attempting to be a root node.
		if (is_null($jobType->parent_type_id)) {
			$rootCount = JobType::whereNull('parent_job_type_id')->get()->count();
			// Only save if there are no other roots.
			return $rootCount == 0;
		}
	}

}
