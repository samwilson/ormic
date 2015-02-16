<?php

namespace Amsys\Model;

class AssetType extends \Illuminate\Database\Eloquent\Model {

	protected $fillable = array('is_default');
	protected $casts = array(
		'is_default' => 'boolean',
	);

	public function __construct($attributes = array()) {
		$attributes['is_default'] = (AssetType::where('is_default', '=', true)->count() == 0);
		parent::__construct($attributes);
	}

	public function setIsDefaultAttribute($value) {
		$this->attributes['is_default'] = $value;
		if ($value) {
			foreach (AssetType::where('is_default', '=', true)->get() as $at) {
				$at->is_default = false;
				$at->save();
			}
		}
	}

	public static function getDefault() {
		$type = AssetType::where('is_default', '=', true)->first();
		if (!$type) {
			if (AssetType::count() > 0) {
				// If there are asset types, use the first.
				$type = AssetType::first();
			} else {
				// If not, create a new one.
				$type = new AssetType();
				$type->title = 'Default Asset Type';
			}
			// Then make it the default.
			$type->is_default = true;
			$type->save();
		}
		return $type;
	}

	public function assets() {
		return $this->hasMany('Amsys\Model\Asset');
	}

}
