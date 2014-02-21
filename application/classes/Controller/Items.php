<?php

class Controller_Items extends Controller_Base {

	public function action_home()
	{
		$this->view->assets = ORM::factory('Item')->find_all();
	}

	public function action_edit()
	{
		$this->view->item = ORM::factory('Item', $this->request->param('id'));
		if ($this->view->item->loaded())
		{
			$this->template->title = "Item #" . $this->view->item->id;
		}
		else
		{
			$this->template->title = "New Item";
			$this->view->datalog = '';
		}
		$this->view->datalog = '';
		$this->view->errors = array();
		if ($this->request->post('save') !== NULL)
		{
			try
			{
				$this->view->item->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('model');
				return;
			}

			$this->redirect(Route::get('items')->uri());
		}
	}

}
