<?php

class Controller_Ormic extends Controller_Base {

	/** @var string lowercase type name */
	protected $type;
	/** @var string camelcased model name */
	protected $model_name;
	/** @var ORM the model object */
	protected $model;

	public function before()
	{
		parent::before();

		/*
		 * Type and model
		 */
		$this->type = $this->request->param('type');
		// Force lowercase type in URL
		if ($this->type !== strtolower($this->type))
		{
			$params = array('type'=>strtolower($this->type), 'action'=>$this->request->action());
			$this->redirect(Route::get('ormic')->uri($params));
		}
		if ( ! $this->model_name = Ormic::model($this->type))
		{
			throw HTTP_Exception::factory(404, ":type model not found", array(':type'=>$this->type));
		}
		// Make sure we can create a model
		try {
			$this->model = ORM::factory($this->model_name);
		}
		catch (Database_Exception $e)
		{
			throw HTTP_Exception::factory(500, 'Unable to load :model model', array(':model'=>$this->model_name), $e);
		}

		/*
		 * Navigation tabs
		 */
		$nav = View::factory('ormic/nav');
		$nav->actions = array(
			'index'=>array(
				'title' => 'Index',
				'url' => Route::url('ormic', array('action'=>'index', 'type'=>$this->type)),
			),
			'new'=>array(
				'title' => 'New',
				'url' => Route::url('ormic', array('action'=>'edit', 'type'=>$this->type)),
			),
			'edit'=>array(
				'title' => 'Edit',
				'url' => Route::url('ormic', array('action'=>'edit', 'type'=>$this->type)),
				'class' => 'disabled',
			),
			'view'=>array(
				'title' => 'View',
				'url' => '',
				'class' => 'disabled',
			),
		);
		$nav->active = $this->request->action();
		$nav->id = NULL;
		$nav->model = $this->model;
		$this->view->nav = $nav;
		$this->view->type = $this->type;
		$this->view->model = $this->model;
	}

	public function action_index()
	{
		$this->view->nav->actions['index']['class'] = 'active';
		$this->view->nav->actions['edit']['class'] = 'disabled';
		// Custom view?
		if (Kohana::find_file("views/model/$this->type", "index"))
		{
			$this->view->set_filename("model/$this->type/index");
		}
		//$this->view->model = $this->model;
		// Join with related tables
		foreach (array_keys($this->model->belongs_to()) as $belongs_to) {
			$this->model->with($belongs_to);
		}
		// Pagination
		$config = array('total_items' => $this->model->count_all());
		$pagination = Pagination::factory($config);
		$this->view->models = $this->model
				->limit($pagination->items_per_page)
				->offset($pagination->offset)
				->find_all();
		$this->view->pagination = $pagination;
		$this->view->cols = $this->model->table_columns();
		$this->view->labels = $this->model->labels();
	}

	public function action_view()
	{
		$id = $this->request->param('id');
		if (Kohana::find_file("views/model/$this->type", "view"))
		{
			$this->view->set_filename("model/$this->type/view");
		}
		$this->model->where('id','=',$id)->find();
		$this->view->nav->active = 'view';
		$this->view->nav->actions['edit']['url'] = Route::url('ormic', array('action'=>'edit', 'type'=>$this->type, 'id'=>$id));
		$this->view->nav->actions['edit']['class'] = '';
	}

	public function action_edit()
	{
		$this->view->nav->active = 'new';
		//$type = $this->request->param('type');
		if (Kohana::find_file("views/model/$this->type", "edit"))
		{
			$this->view->set_filename("model/$this->type/edit");
		}
		$id = $this->request->param('id');
		//$model = $this->view->model = ORM::factory($type, $id);
		$this->view->object_name = $this->model->object_name();
		$this->view->cols = $this->model->table_columns();
		$this->view->labels = $this->model->labels();
		$this->view->errors = array();

		// Get option values for belongs_to relationships
		foreach ($this->model->belongs_to() as $name => $details)
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
		if ($this->model->loaded())
		{
			$this->view->nav->active = 'edit';
			$this->view->nav->actions['view']['url'] = Route::url('ormic', array('action'=>'view', 'type'=>$this->type, 'id'=>$id));
			$this->view->nav->actions['view']['class'] = '';
			$params = array('table_name' => $this->model->table_name(), 'row_pk' => $this->model->id);
			$datalog_url = Route::get('datalog')->uri($params);
			$this->view->datalog = Request::factory($datalog_url)->execute()->body();
		}

		// Save
		if ($this->request->post('save') !== NULL)
		{
			$cols = array_keys($this->model->table_columns());
			$this->model->values($this->request->post(), $cols);
			try
			{
				$this->model->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('error');
				return;
			}
			// Save any has_many relationships
			foreach ($this->model->has_many() as $alias=>$details)
			{
				if ( ! $this->request->post($alias))
				{
					continue;
				}
				//echo Debug::vars($this->request->post($alias));exit();
				$rel = ORM::factory($details['model'], $this->request->post($alias));
				if ($rel->loaded())
				{
					$this->model->add($alias, $rel);
				}
				else
				{
					throw HTTP_Exception::factory(404, 'Related model :alias not found.', array(':alias', $alias));
				}
			}
			$this->redirect(Route::get('ormic')->uri(array('type'=>$this->type, 'id'=>$this->model->id)));
		}

	}

}
