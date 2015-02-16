<?php

use Amsys\Model\Asset;
use Amsys\Model\Job;
use Amsys\Model\JobType;

class JobTypesTest extends TestCase {

	/**
	 * @testdox Every Job Type except a single top level one has a parent Job Type.
	 * @test
	 */
	public function hierarchy() {
		$rootType = new JobType;
		$rootType->title = 'Root';
		$rootType->save();
		$this->assertNull($rootType->parentType);

		$childType = new JobType;
		$childType->title = '2nd Root';
		$childType->save();
		// Should not have saved.
		$this->assertNull($childType->id);
	}

}
