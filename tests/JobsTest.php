<?php

use Amsys\Model\Asset;
use Amsys\Model\Job;
use Amsys\Model\JobType;

class JobsTest extends TestCase {

	/**
	 * @testdox A Job is attached to one Asset.
	 * @test
	 */
	public function basic() {
		$type = new JobType;
		$type->title = 'Test';
		$type->save();
		$job = new Job();
		$job->jobType()->associate($type);
		$this->assertEmpty($job->asset);
		$asset = new Asset();
		$asset->title = 'Test';
		$asset->save();
		$job->asset()->associate($asset);
		$job->save();
		$this->assertNotEmpty($job->asset);
	}

	/**
	 * @testdox A Job has some number of Tasks attached to it.
	 * @test
	 */
	public function task() {
		$job = new Job();
		$this->assertEquals(0, $job->tasks()->count());
	}

	/**
	 * @testdox A Job has a Job Type.
	 * @test
	 */
	public function type() {
		$asset = new Asset();
		$asset->title = 'Test';
		$asset->save();
		$type = new JobType;
		$type->title = 'New Type';
		$type->save();
		$job = new Job;
		$job->asset_id = $asset->id;
		$job->job_type_id = $type->id;
		$job->save();
	}

}
