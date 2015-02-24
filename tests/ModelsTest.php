<?php

class ModelsTest extends TestCase {

	/**
	 * @testdox A model can report its attributes' names.
	 * @test
	 */
	public function basic() {
		$user = new Ormic\Model\User();
		$this->assertContains('id', $user->getAttributeNames());
		$this->assertContains('name', $user->getAttributeNames());
		$this->assertContains('username', $user->getAttributeNames());
	}

	/**
	 * @testdox Relationships...
	 * @test
	 */
	public function foreign() {
	}

}
