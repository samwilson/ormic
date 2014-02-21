<?php

class Model_Tag extends ORM {

	protected $_has_many = array(
		'items' => array('through' => 'items_2_tags'),
	);

}
