<?php namespace Ormic\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * @group ormic
 */
class DatalogTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Schema::create('books', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('authors');
        });
        Schema::create('authors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
        Model\Book::observe(new \Ormic\Observers\Datalog());
        Model\Author::observe(new \Ormic\Observers\Datalog());
    }

    /**
     * @testdox The datalog tracks all changes to all models.
     * @test
     */
    public function create()
    {
        $user = new \Ormic\Model\User();
        $user->name = 'Test User';
        $user->username = 'test';
        $user->save();

        // Retrieve the datalog.
        $datalog = $user->getDatalog();
        $this->assertCount(3, $datalog);

        // First row.
        $this->assertEquals('id', $datalog[0]->field);
        $this->assertNull($datalog[0]->old_value);
        $this->assertEquals(1, $datalog[0]->new_value);
        // Second row.
        $this->assertEquals('username', $datalog[1]->field);
        $this->assertNull($datalog[1]->old_value);
        $this->assertEquals('test', $datalog[1]->new_value);
        // Third row.
        $this->assertEquals('name', $datalog[2]->field);
        $this->assertNull($datalog[2]->old_value);
        $this->assertEquals('Test User', $datalog[2]->new_value);

        // Change the record.
        $user->name = 'Bill';
        $user->save();
        $datalog2 = $user->getDatalog();
        $this->assertCount(4, $datalog2);
        $this->assertEquals('name', $datalog2[0]->field);
        $this->assertEquals('Test User', $datalog2[0]->old_value);
        $this->assertEquals('Bill', $datalog2[0]->new_value);
    }

    /**
     * @testdox All changes are attributed to a user.
     * @test
     */
    public function attribution()
    {
        // Create two users.
        $user1 = new \Ormic\Model\User();
        $user1->username = 'One';
        $user1->save();
        $this->assertEquals(1, $user1->id);
        $user2 = new \Ormic\Model\User();
        $user2->username = 'Two';
        $user2->save();
        $this->assertEquals(2, $user2->id);

        // Create a record to edit.
        $book = new Model\Book();
        $book->setUser($user1);
        $book->title = 'Test Book';
        $book->save();

        // Make sure it was edited by the correct user.
        $datalog1 = $book->getDatalog();
        $this->assertEquals(1, $datalog1[0]->user_id);

        // Edit the record, and check the new datalog record.
        $book->setUser($user2);
        $book->title = 'Test Title';
        $book->save();
        $datalog2 = $book->getDatalog();
        $this->assertEquals(2, $datalog2[0]->user_id);
    }

    /**
     * @testdox Foreign key modifications are tracked in the datalog by their titles (rather than IDs). This means that modifications to one record's title may result in changes appearing in the datalog of other records.
     * @test
     */
    public function foreignKeyTitles()
    {
        // Set up.
        $user = $this->getTestUser();

        $book1 = new Model\Book();
        $book1->setUser($user);
        $book1->title = 'Test Book with FK';
        $book1->save();
        $this->assertEquals(1, $book1->id);
        $this->assertEquals('Test Book with FK', $book1->title);
        $this->assertCount(2, $book1->getDatalog());

        // Create an author.
        $author = new Model\Author();
        $author->setUser($user);
        $author->name = 'Book Author';
        $author->save();
        $this->assertCount(2, $author->getDatalog());

        // Create a book.
        $book = new Model\Book();
        $book->setUser($user);
        $book->title = 'Test Book';
        $book->author_id = $author->id;
        $book->save();
        $this->assertCount(3, $book->getDatalog());

        // Check that the recorded value for author_id was actually the title of the Author record.
        $datalog = $book->getDatalog();
        $this->assertEquals('author_id', $datalog[1]->field);
        $this->assertEquals('Book Author', $datalog[1]->new_value);
    }
}
