<?php

class Controller_Ormic extends Controller_Base {

	public function action_index()
	{
		$t = $this->request->param('type');
		// Force lowercase type in URL
		if ($t !== strtolower($t))
		{
			$this->redirect(Route::get('ormic')->uri(array('type'=>strtolower($t))));
		}
		$plural = Inflector::plural($t);
		if (Kohana::find_file('views/model', $plural))
		{
			$this->view->set_filename('model/'.$plural);
		}
		else
		{
			$this->view->set_filename('ormic/index');
		}

		if ( ! $model_name = Ormic::model($t))
		{
			throw HTTP_Exception::factory(404, ":type model not found", array(':type'=>$t));
		}
		$model = ORM::factory($model_name);
		$this->view->models = $model->find_all();
		$this->view->object_name = $model->object_name();
		$this->view->cols = $model->table_columns();
		$this->view->labels = $model->labels();
	}

	public function action_view()
	{
		$type = $this->request->param('type');
		$id = $this->request->param('id');
		$model = $this->view->model = ORM::factory($type, $id);
		$this->view->object_name = $model->object_name();
		$this->view->cols = $model->table_columns();
	}

	public function action_edit()
	{
		$type = $this->request->param('type');
		if (Kohana::find_file('views/model', $type))
		{
			$this->view->set_filename('model/'.$type);
		}
		else
		{
			$this->view->set_filename('ormic/edit');
		}
		$id = $this->request->param('id');
		$model = $this->view->model = ORM::factory($type, $id);
		$this->view->object_name = $model->object_name();
		$this->view->cols = $model->table_columns();
		$this->view->labels = $model->labels();
		$this->view->errors = array();

		// Get option values for belongs_to relationships
		foreach ($model->belongs_to() as $name => $details)
		{
			$foreign = ORM::factory($details['model']);
			if (method_exists($foreign, 'option_values'))
			{
				$options = $foreign->option_values();
				$plural = $foreign->object_plural();
				$this->view->$plural = $options;
			}
		}

		// Datalog
		$this->view->datalog = '';
		if ($model->loaded())
		{
			$params = array('table_name' => $model->table_name(), 'row_pk' => $model->id);
			$datalog_url = Route::get('datalog')->uri($params);
			$this->view->datalog = Request::factory($datalog_url)->execute()->body();
		}

		// Save
		if ($this->request->post('save') !== NULL)
		{
			$cols = array_keys($model->table_columns());
			$model->values($this->request->post(), $cols);
			try
			{
				$model->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('model');
				return;
			}
			$this->redirect(Route::get('ormic')->uri(array('type'=>$type, 'id'=>$model->id)));
		}

	}

}
