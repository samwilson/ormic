<?php namespace Ormic\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * @group ormic
 */
class ModelsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('books', function (Blueprint $table) {
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
     * @testdox By default, only Administrators can modify data.
     */
    public function permission()
    {
        // Set up two users, one admin and one not. The first created user is
        // always an admin.
        $admin = new \Ormic\Model\User();
        $admin->username = 'admin';
        $admin->save();
        $this->assertTrue($admin->isAdmin());
        $nonAdmin = new \Ormic\Model\User();
        $nonAdmin->username = 'nonadmin';
        $nonAdmin->save();
        $this->assertFalse($nonAdmin->isAdmin());

        // Start a new model.
        $book = new Model\Book();
        $book->setUser($nonAdmin);
        $this->assertFalse($book->canEdit());
        $book->setUser($admin);
        $this->assertTrue($book->canEdit());
    }
}
