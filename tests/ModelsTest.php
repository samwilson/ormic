<?php namespace Ormic\Tests;

/**
 * @group ormic
 */
class ModelsTest extends TestCase {

    /**
     * @testdox A model has some number of columns.
     * @test
     */
    public function columns()
    {
        $user = new \Ormic\Model\User();
        $columns = $user->getColumns();
        $columnNames = array_keys($columns);
        $this->assertContains('id', $columnNames);
        $this->assertContains('name', $columnNames);
        $this->assertContains('username', $columnNames);
        $this->assertContains('email', $columnNames);
        $usernameCol = $columns['username'];
        $this->assertFalse($usernameCol->nullable());
        $emailCol = $columns['email'];
        $this->assertTrue($emailCol->nullable());
    }

}
