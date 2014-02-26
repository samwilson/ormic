<?php

class ORM extends Kohana_ORM {

	public function labels()
	{
		$labels = array_keys($this->table_columns());
		return array_combine($labels, array_map('Text::titlecase', $labels));
	}

	public function save(Validation $validation = NULL)
	{
		$datalog = new DataLog($this->_table_name, $this->_original_values);
		$parent = parent::save($validation);
		$datalog->save($this->pk(), $this->_object, $this->_belongs_to);
		return $parent;
	}

	/**
	 * Get the model that is related to a given database table.
	 * @uses ORM::_related()
	 * @param string $column_name
	 * @return ORM
	 */
	public function related_model($column_name)
	{
		$poss_alias = substr($column_name, 0, -strlen($this->_foreign_key_suffix));
		return $this->_related($poss_alias);
	}

	/**
	 * A wrapper around Auth::logged_in($role) for use in ORM rules.
	 * 
	 * Example:
	 * 
	 *     public function rules()
	 *     {
	 *       return array(
	 *         'id' => array(
	 *           array(array('ORM','logged_in'), array(':field',':validation','Editor')),
	 *         ),
	 *       );
	 *     }
	 *
	 * @param string $role
	 */
	public static function logged_in($field, Validation $validation, $role)
	{
		$logged_in = Auth::instance()->logged_in($role);
		if ( ! $logged_in)
		{
			$validation->error($field, 'logged_in', array(':role'=>$role));
			return FALSE;
		}
		return TRUE;
	}

}
