<?php

namespace Ormic\Model;

use Illuminate\Support\Facades\DB;

abstract class Base extends \Illuminate\Database\Eloquent\Model {

	/** @var boolean */
	public $timestamps = false;
	protected $hasOne = array();
	protected $hasMany = array();

	public function getHasOne() {
		return $this->hasOne;
	}

	public function getHasMany() {
		return $this->hasMany;
	}

	public function getAttributeNames() {

		switch (DB::connection()->getConfig('driver')) {
			case 'sqlite':
				$query = "pragma table_info(" . $this->getTable() . ")";
				$column_name = 'name';
				$reverse = false;
				break;

			case 'pgsql':
				$query = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->getTable() . "'";
				$column_name = 'column_name';
				$reverse = true;
				break;

			case 'mysql':
				$query = 'SHOW COLUMNS FROM ' . $this->getTable();
				$column_name = 'Field';
				$reverse = false;
				break;

			case 'sqlsrv':
				$parts = explode('.', $this->getTable());
				$num = (count($parts) - 1);
				$table = $parts[$num];
				$query = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
				$column_name = 'column_name';
				$reverse = false;
				break;

			default:
				$error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
				throw new \Exception($error);
				break;
		}
		$columns = array();
		foreach (DB::select($query) as $column) {
			$columns[$column->$column_name] = $column->$column_name; // setting the column name as key too
		}
		if ($reverse) {
			$columns = array_reverse($columns);
		}
		return $columns;
	}

	public function getAttributeTitle($attribute) {
		$value = $this->$attribute;
		if ($relation = $this->getRelation($attribute)) {
			$title = $this->$relation->getTitle();
		} else {
			$title = $value;
		}
		return $title;
	}

	/**
	 * Get the relation name for a given attribute.
	 * 
	 * If an attribute name ends in '_id' then it is a foreign key, and has a
	 * corresponding relation named the same but without the suffix.
	 * 
	 * @param string $attr
	 * @return string|false The relation name, or false if the attribute is not a relation.
	 */
	public function getRelation($attr) {
		if (substr($attr, -3) == '_id') {
			return substr($attr, 0, -3);
		}
		return false;
	}

	public function getTitle() {
		if (isset($this->title)) {
			return $this->title;
		}
		return $this->id;
	}

	public function getUrl($action = '') {
		$url = snake_case(str_plural(class_basename($this)), '-');
		$url .= '/' . $this->id;
		$url .= ($action) ? "/$action" : "";
		return url($url);
	}

	/**
	 * Shortcut to get the ID of a given model, based on its title.
	 * @param string $title
	 * @return integer
	 */
	public static function getId($title) {
		return self::firstOrCreate(array('title' => $title))->id;
	}

	/**
	 * Set a belongs-to relation, creating the foreign entity if it doesn't already exist.
	 * @param string $rel
	 * @param string $title
	 */
	public function setBelongsTo($rel, $title) {
		$exists = $this->$rel->first();
		if (!$exists->id) {
			
		}
	}

}
