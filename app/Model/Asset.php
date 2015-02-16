<?php

namespace Amsys\Model;

class Asset extends \Illuminate\Database\Eloquent\Model {

	const STATUS_INACTIVE = 10;
	const STATUS_ACTIVE = 20;

	protected $fillable = array('asset_type_id');

	public function __construct($attributes = array()) {
		if (!isset($attributes['asset_type_id'])) {
			$type = AssetType::getDefault();
			$attributes['asset_type_id'] = $type->id;
		}
		parent::__construct($attributes);
	}

	public function status() {
		if ($this->jobs->count() > 0) {
			return self::STATUS_ACTIVE;
		} else {
			return self::STATUS_INACTIVE;
		}
	}

	public function type() {
		return $this->belongsTo('Amsys\Model\AssetType');
	}

	public function jobs() {
		return $this->hasMany('Amsys\Model\Job');
	}

	public function scopeTitleIn($query, $list) {
		$titles = explode("\n", $list);
		return $query->whereIn('title', $titles);
	}

	public static function titlesNotFound($list) {
		$existing = array();
		foreach (Asset::titleIn($list)->get() as $a) {
			$existing[] = $a->title;
		}
		$all = explode("\n", $list);
		return array_diff($all, $existing);
	}

}
