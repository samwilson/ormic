<?php

class Model_Item extends ORM {

	protected $_has_many = array(
		'tags' => array('through' => 'items_2_tags'),
	);

	public function __construct($id = NULL)
	{
		$item_files = Kohana::list_files('classes/Model/Item');
		foreach ($item_files as $file)
		{
			$model_name = mb_substr(basename($file), 0, -mb_strlen(EXT));
			$this->_has_one[strtolower($model_name)] = array('model' => 'Item_' . $model_name);
		}
		return parent::__construct($id);
	}

	public function candidate_key()
	{
		if ( ! $this->loaded())
		{
			return FALSE;
		}
		return $this->id;
	}

}
