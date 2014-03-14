<?php

class Controller_Home extends Controller_Base {

	public function action_home()
	{
		$modules = array();
		foreach (Kohana::modules() as $mod)
		{
			$models = array();
			$model_path = MODPATH . basename($mod) . '/classes/Model';
			if ( ! is_dir($model_path))
			{
				continue;
			}
			foreach (scandir($model_path) as $model)
			{
				$model_name = substr(basename($model), 0, -4);
				if ( ! class_exists('Model_' . $model_name))
				{
					continue;
				}
				$models[] = $model_name;
			}
			$modules[basename($mod)] = $models;
		}
		$this->view->modules = Kohana::list_files('classes/Model');

		$this->view->models = array();
		foreach (Arr::flatten(Kohana::list_files('classes/Model')) as $model)
		{
			$model_name = substr(basename($model), 0, -4);
			$class_name = 'Model_' . $model_name;
			if ( ! class_exists($class_name))
			{
				continue;
			}
			$ref = new ReflectionClass($class_name);
			if ($ref->getParentClass()
				AND $ref->getParentClass()->getName() == 'ORM'
				AND $ref->isInstantiable())
			{
				$count = ORM::factory($model_name)->count_all();
				$this->view->models[$model_name] = $count;
			}
		}
	}

}
