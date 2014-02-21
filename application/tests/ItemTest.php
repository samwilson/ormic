<?php

/**
 * @group application
 */
class ItemTest extends PHPUnit_Framework_TestCase {

	protected function setUp()
	{
		parent::setUp();
		Database::instance()->begin();
	}

	protected function tearDown()
	{
		Database::instance()->rollback();
		parent::tearDown();
	}

}
