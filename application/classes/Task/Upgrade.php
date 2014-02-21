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

		// Application
		$this->initial_install();

		// Modules
		$datalog = new Task_DataLog();
		$datalog->execute();
		$mailqueue = new Task_MailQueue_Upgrade();
		$mailqueue->execute();

		// ItemDB models
		foreach (array_keys(Kohana::modules()) as $module)
		{
			$task_name = $module . '_ItemDBUpgrade';
			if (class_exists($task_name))
			{
				Minion_CLI::write("Running upgrade from $module module.");
				new $task_name();
			}
		}
	}

	private function initial_install()
	{

		// Tags table
		if ( ! $this->db->list_tables('tags'))
		{
			Minion_CLI::write("Creating table: tags");
			$sql = "CREATE TABLE " . $this->db->quote_table('tags') . " ("
					. $this->db->quote_column('id') . " INT(5) NOT NULL AUTO_INCREMENT,"
					. $this->db->quote_column('name') . " VARCHAR(80) NOT NULL,"
					. "PRIMARY KEY (" . $this->db->quote_column('id') . "),"
					. "UNIQUE KEY `name` (" . $this->db->quote_column('name') . ")"
					. ") ENGINE=InnoDB;";
			$this->db->query(NULL, $sql);
		}

		// Items table
		if ( ! $this->db->list_tables('items'))
		{
			Minion_CLI::write("Creating table: items");
			$sql = "CREATE TABLE " . $this->db->quote_table('items') . " ("
					. $this->db->quote_column('id') . " INT(15) NOT NULL AUTO_INCREMENT,"
					. "PRIMARY KEY (" . $this->db->quote_column('id') . ")"
					. ") ENGINE=InnoDB;";
			$this->db->query(NULL, $sql);
		}

		// Items-Tags table
		if ( ! $this->db->list_tables('items_2_tags'))
		{
			Minion_CLI::write("Creating table: items_2_tags");
			$sql = "CREATE TABLE " . $this->db->quote_table('items_2_tags') . " ("
					. $this->db->quote_column('item_id') . " INT(10) NOT NULL,"
					. $this->db->quote_column('tag_id') . " INT(5) NOT NULL,"
					. "PRIMARY KEY (" . $this->db->quote_column('item_id') . ", " . $this->db->quote_column('tag_id') . "),"
					. "CONSTRAINT " . $this->db->quote_identifier('item')
					. "  FOREIGN KEY (" . $this->db->quote_column('item_id') . ")"
					. "  REFERENCES " . $this->db->quote_table('items') . " (" . $this->db->quote_column('id') . ")"
					. "  ON DELETE CASCADE,"
					. "CONSTRAINT " . $this->db->quote_identifier('tag')
					. "  FOREIGN KEY (" . $this->db->quote_column('tag_id') . ")"
					. "  REFERENCES " . $this->db->quote_table('tags') . " (" . $this->db->quote_column('id') . ")"
					. "  ON DELETE CASCADE"
					. ") ENGINE=InnoDB;";
			$this->db->query(NULL, $sql);
		}
	}

}
