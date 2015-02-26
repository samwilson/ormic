<?php namespace Ormic\Tests;

/**
 * @group ormic
 */
class CSVTest extends TestCase {

	/** @var string */
	private $testFile;

	public function setUp()
	{
		parent::setUp();
		$this->testFile = storage_path() . '/' . uniqid() . '.csv';
		$csv = "H1,H2,Head Three\nOne,Two,Three\nFour,Five,Six";
		file_put_contents($this->testFile, $csv);
	}

	public function tearDown()
	{
		unlink($this->testFile);
		return parent::tearDown();
	}

	/**
	 * @testdox A CSV file can be loaded by filename, and read one line at a time. Row fields are read by column header.
	 */
	public function basic()
	{
		$csv = new \Ormic\CSV($this->testFile);
		$csv->next();
		$this->assertEquals('One', $csv->get('H1'));
		$this->assertEquals('Two', $csv->get('H2'));
		$this->assertEquals('Three', $csv->get('Head Three'));
		$csv->next();
		$this->assertEquals('Four', $csv->get('H1'));
		$this->assertEquals('Five', $csv->get('H2'));
		$this->assertEquals('Six', $csv->get('Head Three'));
	}

	/**
	 * @testdox Column headers are case-insensitive.
	 */
	public function caseInsensitive()
	{
		$csv = new \Ormic\CSV($this->testFile);
		$csv->next();
		$this->assertEquals('Three', $csv->get('HEAD Three'));
		$csv->next();
		$this->assertEquals('Six', $csv->get('head THRee'));
	}

	/**
	 * @testdox If two headers map to the same 'slug', the right-most one is used.
	 */
	public function multiple()
	{
		// Set up CSV.
		$csvText = "Head One,H2,head one\nOne,Two,Three\nFour,Five,Six";
		file_put_contents($this->testFile, $csvText);

		// Test.
		$csv = new \Ormic\CSV($this->testFile);
		$csv->next();
		$this->assertEquals('Three', $csv->get('Head One'));
		$csv->next();
		$this->assertEquals('Six', $csv->get('head one'));
	}

}
