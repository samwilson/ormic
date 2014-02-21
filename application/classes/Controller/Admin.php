<?php

class Controller_Admin extends Controller_Base {

	public function action_home()
	{
		$this->template->title = 'Administration';
		$this->view->owners = ORM::factory('AssetOwner')
				->order_by('name')
				->find_all();
		$this->view->types = ORM::factory('AssetType')
				->order_by('name')
				->find_all();
	}

	public function action_owner()
	{
		$this->view->owner = ORM::factory('AssetOwner', $this->request->param('id'));
		if ($this->view->owner->loaded())
		{
			$this->template->title = "Edit '" . $this->view->owner->name . "'";
		}
		else
		{
			$this->template->title = "New Owner";
		}
		$datalog_url = Route::get('datalog')->uri(array('table_name' => 'asset_owners', 'row_pk' => $this->view->owner->id));
		$this->view->datalog = Request::factory($datalog_url)->execute()->body();

		$this->view->errors = array();
		if ($this->request->post('name') !== NULL)
		{
			$this->view->owner->name = $this->request->post('name');
			try
			{
				$this->view->owner->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('model');
				return;
			}

			$this->redirect('admin');
		}
	}

	public function action_type()
	{
		$this->view->type = ORM::factory('AssetType', $this->request->param('id'));
		if ($this->view->type->loaded())
		{
			$this->template->title = "Edit '" . $this->view->type->name . "'";
		}
		else
		{
			$this->template->title = "New Asset Type";
		}
		$datalog_url = Route::get('datalog')->uri(array('table_name' => 'asset_types', 'row_pk' => $this->view->type->id));
		$this->view->datalog = Request::factory($datalog_url)->execute()->body();

		$this->view->errors = array();
		if ($this->request->post('name') !== NULL)
		{
			$this->view->type->name = $this->request->post('name');
			try
			{
				$this->view->type->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('model');
				return;
			}

			$this->redirect('admin');
		}
	}

}
