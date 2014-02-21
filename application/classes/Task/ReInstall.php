<?php

/**
 * This task reinstalls the application. All data is destroyed!
 */
class Task_ReInstall extends Minion_Task {

	/**
	 * Drop all tables and then run the normal upgrade task [Task_Upgrade::_execute()].
	 * This is done in preference to dropping and recreating the database
	 * firstly because it can be done within a Minion task,
	 * and secondly because this way the DB user doesn't have to have DROP DATABASE permissions.
	 *
	 * This will not execute in a Production environment.
	 *
	 * @param array $params
	 * @return void
	 */
	protected function _execute(array $params)
	{
		Minion_CLI::write("Reinstallation of ".SITE_TITLE.".");

		// Prevent inadvertent execution.
		if (Kohana::$environment == Kohana::PRODUCTION)
		{
			Minion_CLI::write("Database reinstallation can not be done on Production sites.");
			return;
		}
		$db = Database::instance();
		$db_name = Kohana::$config->load('database.default.connection.database');
		$confirm = Minion_CLI::read('You are about to DESTROY the '.$db_name.' database. Confirm with "yes"');
		if ($confirm !== 'yes')
		{
			Minion_CLI::write("Reinstallation aborted.");
			return;
		}

		// Proceed with the reinstallation.
		Minion_CLI::write("Dropping all tables.");
		$db->query(NULL, 'SET foreign_key_checks = 0');
		$tables = $db->list_tables();
		foreach ($tables as $table)
		{
			$db->query(NULL, 'DROP TABLE '.$db->quote_table($table));
		}
		$db->query(NULL, 'SET foreign_key_checks = 1');

		$upgrade = new Task_Upgrade;
		$upgrade->execute();
	}

}
