<?php

class ItemDB {

	/**
	 * Get a list of file/model names of item types.
	 *
	 * @return array The available item types.
	 */
	public static function get_types()
	{
		$out = array();
		$item_files = Kohana::list_files('classes/Model/Item');
		foreach ($item_files as $file)
		{
			$out[] = mb_substr(basename($file), 0, -mb_strlen(EXT));
		}
		return $out;
	}

}
