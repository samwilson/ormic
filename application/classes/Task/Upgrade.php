<?php

/**
 * This task upgrades the application (database and filesystem data).
 * It is idempotent.
 */
class Task_Upgrade extends Minion_Task {

	/** @var Database */
	private $db;

	/** @var string */
	private $prefix;

	protected function _execute(array $params)
	{
		$this->db = Database::instance();
		$this->prefix = $this->db->table_prefix();

		// Modules
		$datalog = new Task_DataLog();
		$datalog->execute();
		$mailqueue = new Task_MailQueue_Upgrade();
		$mailqueue->execute();

		// Ormic modules
		foreach (array_keys(Kohana::modules()) as $module)
		{
			$task_name = $module . '_OrmicUpgrade';
			if (class_exists($task_name))
			{
				Minion_CLI::write("Running upgrade from the '$module' module.");
				new $task_name();
			}
		}

	}

}
