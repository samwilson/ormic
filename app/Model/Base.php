<?php

namespace Ormic\Model;

abstract class Base extends \Illuminate\Database\Eloquent\Model {

	public function getAttributeNames() {
		return array_keys($this->attributes);
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
