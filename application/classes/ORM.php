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

}
