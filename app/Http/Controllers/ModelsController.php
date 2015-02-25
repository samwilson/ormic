<?php

namespace Ormic\Http\Controllers;

class ModelsController extends \Ormic\Http\Controllers\Controller {

	/** @var \Ormic\Model\Base */
	protected $model;

	public function setUpModel($modelSlug) {
		$modelName = ucfirst(camel_case(str_singular($modelSlug)));
		$modules = new \Ormic\Modules();
		$module = $modules->getModuleOfModel($modelName);
		if ($module) {
			$modelClass = 'Ormic\Modules\\' . $module . '\Model\\' . $modelName;
		} else {
			$modelClass = 'Ormic\Model\\' . $modelName;
		}
		$this->model = new $modelClass();
		$this->view->title = ucwords(str_replace('-', ' ', $modelSlug));
		$this->view->modelSlug = $modelSlug;
		$this->view->attributes = $this->model->getAttributeNames();
		$this->view->record = $this->model;
	}

	public function index($modelSlug) {
		$this->setUpModel($modelSlug);
		$this->view->records = $this->model->all();
		return $this->view;
	}

	public function view($modelSlug, $id) {
		$this->setUpModel($modelSlug);
		$this->view->record = $this->model->find($id);
		foreach ($this->model->getHasOne() as $oneName=>$oneClass) {
			$this->view->$oneName = new $oneClass();
		}
		return $this->view;
	}

	public function form($modelSlug, $id = false) {
		$this->setUpModel($modelSlug);
		$this->view->active = 'create';
		$this->view->action = $modelSlug . '/new';
		$this->view->record = $this->model;
		if ($id) {
			$this->view->record = $this->model->find($id);
			$this->view->active = 'edit';
			$this->view->action = $modelSlug . '/' . $this->view->record->id;
		}
		return $this->view;
	}

	public function save($modelSlug, $id = false) {
		$this->setUpModel($modelSlug);
		$model = ($id) ? $this->model->find($id) : $this->model;
		foreach ($this->model->getAttributeNames() as $attr) {
			$model->$attr = \Illuminate\Support\Facades\Input::get($attr);
		}
		$model->save();
		return redirect($modelSlug . '/' . $model->id);
	}

}
