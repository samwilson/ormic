<?php namespace Ormic\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * @group ormic
 */
class ModelsTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        Schema::create('authors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('books', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });
    }

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

    /**
     * @testdox All changes are recorded.
     */
    public function changes()
    {
        
    }

}
