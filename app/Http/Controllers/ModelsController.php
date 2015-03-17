<?php namespace Ormic\Http\Controllers;

use \Illuminate\Support\Facades\Input;

class ModelsController extends \Ormic\Http\Controllers\Controller
{

    /** @var \Ormic\Model\Base */
    protected $model;

    protected function setUpModel(\Illuminate\Http\Request $request)
    {
        $uri = $request->route()->uri();
        $modelSlug = strpos($uri, '/') ? substr($uri, 0, strpos($uri, '/')) : $uri;
        $modelName = ucfirst(camel_case(str_singular($modelSlug)));
        $modules = new \Ormic\Modules();
        $module = $modules->getModuleOfModel($modelName);
        if ($module) {
            $modelClass = 'Ormic\modules\\' . $module . '\Model\\' . $modelName;
            $viewName = snake_case($module) . '::' . snake_case($modelName) . '.' . $this->currentAction;
        } else {
            $modelClass = 'Ormic\Model\\' . $modelName;
            $viewName = snake_case($modelName) . '.' . $this->currentAction;
        }
        $this->model = new $modelClass();
        $this->model->setUser($this->user);

        try {
            $this->view = view($viewName);
        } catch (\InvalidArgumentException $ex) {
            try {
                $this->view = view('models.' . $this->currentAction);
            } catch (\InvalidArgumentException $ex) {
                // Still no view; give up.
                $this->view = view();
            }
        }
        $this->view->title = ucwords(str_replace('-', ' ', $modelSlug));
        $this->view->modelSlug = $modelSlug;
        $this->view->columns = $this->model->getColumns();
        $this->view->record = $this->model;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $this->setUpModel($request);
        $this->view->records = $this->model->paginate();
        return $this->view;
    }

    public function view(\Illuminate\Http\Request $request, $id)
    {
        $this->setUpModel($request);
        $this->view->record = $this->model->find($id);
        $this->view->record->setUser($this->user);
        foreach ($this->model->getHasOne() as $oneName => $oneClass) {
            $this->view->$oneName = new $oneClass();
        }
        $this->view->datalog = $this->view->record->getDatalog();
        return $this->view;
    }

    public function form(\Illuminate\Http\Request $request, $id = false)
    {
        $this->setUpModel($request);
        $this->view->active = 'create';
        $this->view->action = $this->model->getSlug() . '/new';
        $this->view->record = $this->model;
        $this->view->record->setUser($this->user);
        if ($id) {
            $this->view->record = $this->model->find($id);
            $this->view->record->setUser($this->user);
            $this->view->active = 'edit';
            $this->view->action = $this->model->getSlug() . '/' . $this->view->record->id;
            if (!$this->view->record->canEdit()) {
                $this->alert('warning', 'You are not permitted to edit this record.');
            }
        } elseif (!$this->view->record->canCreate()) {
            $msg = 'You are not permitted to create new '
              . titlecase(snake_case($this->model->getSlug(), ' ')) . ' records.';
            $this->alert('warning', $msg);
        }

        return $this->view;
    }

    public function save(\Illuminate\Http\Request $request, $id = false)
    {
        $this->setUpModel($request);
        $model = ($id) ? $this->model->find($id) : $this->model;
        $model->setUser($this->user);
        if ($model->id && !$model->canEdit()) {
            throw new \Exception('Editing denied.');
        }
        if (!$model->id && !$model->canCreate()) {
            throw new \Exception('Creating denied.');
        }
        foreach ($this->model->getColumns() as $column) {
            $colName = $column->getName();
            if (Input::get($colName)) {
                $model->$colName = Input::get($colName);
            }
        }
        if (!$model->save()) {
            foreach ($model->getErrors() as $err) {
                $this->alert('warning', $err);
            }
        }
        $this->alert('success', "Data saved successfully.", true);
        return redirect($this->model->getSlug() . '/' . $model->id);
    }
}
