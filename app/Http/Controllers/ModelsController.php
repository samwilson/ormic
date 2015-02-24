<?php

namespace Ormic\Http\Controllers;

class ModelsController extends \Ormic\Http\Controllers\Controller {
	/** @var string */
//	private $module;
//
//	/** @var string */
//	private $modelName;
//
//	/** @var string */
//	private $modelClassName;

	/** @var \Ormic\Model\Base */
	protected $model;

	/** @var \Illuminate\Support\Facades\View */
	//protected $view;
//	public function __construct() {
//		parent::__construct();
//		$controllerPath = explode('\\', get_called_class());
//		$this->modelName = substr(array_pop($controllerPath), 0, -(strlen('Controller')));
//		$modules = new \Ormic\Modules();
//		$this->module = $modules->getModuleOfModel($this->modelName);
//		$this->modelClassName = 'Ormic\Modules\\' . $this->module . '\Model\\' . $this->modelName;
//		$this->model = new $this->modelClassName();
//		$this->view = view($this->module . '::' . snake_case($this->modelName) . '.' . $this->currentAction);
//	}
	public function setUpModel($modelSlug) {
		$modelName = ucfirst(camel_case(str_singular($modelSlug)));
		$modules = new \Ormic\Modules();
		$module = $modules->getModuleOfModel($modelName);
		$modelClass = 'Ormic\Modules\\' . $module . '\Model\\' . $modelName;
		$this->model = new $modelClass();
		$this->view->title = ucwords(str_replace('-', ' ', $modelSlug));
		$this->view->modelSlug = $modelSlug;
		$this->view->attributes = $this->model->first()->getAttributeNames();
		$this->view->record = false;
	}

	public function index($modelSlug) {
		$this->setUpModel($modelSlug);
		$this->view->records = $this->model->all();
		return $this->view;
	}

	public function view($modelSlug, $id) {
		$this->setUpModel($modelSlug);
		$this->view->record = $this->model->find($id);
		return $this->view;
	}

	public function form($modelSlug, $id = false) {
		$this->setUpModel($modelSlug);
		$this->view->active = 'create';
		if ($id) {
			$this->view->record = $this->model->find($id);
			$this->view->active = 'edit';
		}
		return $this->view;
	}

}
