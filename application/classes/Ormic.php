<?php

class Ormic {

	public static function menu()
	{
		$config = Kohana::$config->load('ormic')->get('mainmenu');
		return (empty($config)) ? array() : $config;
	}

	/**
	 * Get a model name from a lowercase equivalent.
	 *
	 * @param string $name Lowercase model name
	 * @return string The model name
	 * @return boolean False if none could be found
	 */
	public static function model($name)
	{
		foreach (Kohana::list_files('classes/Model') as $file)
		{
			if ( ! is_string($file))
			{
				continue;
			}
			$model_name = substr(basename($file), 0, -mb_strlen(EXT));
			if (strtolower($name) == strtolower($model_name))
			{
				return $model_name;
			}
		}
		return FALSE;
	}

	public function models()
	{
		$out = array();
		$tables = Database::instance()->list_tables();
		foreach ($tables as $table)
		{
			$class_names = array(
				// Normal
				Text::ucfirst($table, '_'),
				// Collapsed
				str_replace('_', '', Text::ucfirst($table, '_')),
				// Singular
				Text::ucfirst(Inflector::singular($table), '_'),
				// Singular collapsed
				str_replace('_', '', Text::ucfirst(Inflector::singular($table), '_')),
			);
			foreach ($class_names as $name)
			{
				if (class_exists('Model_' . $name))
				{
					$out[] = ORM::factory($name);
				}
			}
		}
		return $out;
	}

}
