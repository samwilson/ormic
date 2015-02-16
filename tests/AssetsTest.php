<?php

use Amsys\Model\Asset;
use Amsys\Model\AssetType;
use Amsys\Model\Job;
use Amsys\Model\JobType;

class AssetsTest extends TestCase {

	/**
	 * @testdox An asset has a mandatory and unique title.
	 * @test
	 */
	public function assets() {
		$this->assertEmpty(Asset::all());
		$asset = new Asset;
		$asset->title = 'Asset 12345';
		$asset->save();
		$this->assertCount(1, Asset::all());
		$retrievedAsset = Asset::where('title', '=', 'Asset 12345')->first();
		$this->assertEquals($retrievedAsset->id, $asset->id);
		$asset2 = new Asset;
		$asset2->title = 'Asset 12345';
		$this->setExpectedException('Illuminate\Database\QueryException');
		$asset2->save();
	}

	/**
	 * @testdox An asset has a status: 'Active', or 'Inactive'.
	 * @test
	 */
	public function assetTitle() {
		$asset = new Asset;
		$asset->title = 'Asset 12345';
		$asset->save();
		$retrievedAsset = Asset::where('title', '=', 'Asset 12345')->first();
		$this->assertEquals($retrievedAsset->status(), Asset::STATUS_INACTIVE);
	}

	/**
	 * @testdox If an asset has no open Jobs, then its status is 'Inactive'.
	 */
	public function statuses() {
		$asset = new Asset;
		$asset->title = 'Test Asset';
		$asset->save();

		// When there are no jobs.
		$this->assertCount(0, $asset->jobs);
		$this->assertEquals($asset->status(), Asset::STATUS_INACTIVE);

		$jobType = new JobType;
		$jobType->title = 'Root';
		$jobType->save();
		$job = new Job;
		$job->asset_id = $asset->id;
		$job->job_type_id = $jobType->id;
		$job->save();
		$asset->load('jobs');
		$this->assertEquals('Test Asset', $job->asset->title);
		$this->assertCount(1, $asset->jobs);
		$this->assertNotEquals($asset->status(), Asset::STATUS_INACTIVE);
	}

	/**
	 * @testdox An arbitrary list of assets can be retrieved (via unique titles; one per line).
	 * @test
	 */
	public function search() {
		$assetTitles = array('One', 'Two', 'Three', 'Four', 'Five');
		foreach ($assetTitles as $title) {
			$asset = new Asset;
			$asset->title = $title;
			$asset->save();
		}
		$this->assertCount(5, Asset::all());
		$this->assertCount(2, Asset::titleIn("One\nFour")->get());
		$this->assertCount(2, Asset::titleIn("One\nFour\nEight")->get());
	}

	/**
	 * @testdox Assets in a list that are not in the DB can be reported.
	 * @test
	 */
	public function searchNoTitle() {
		$assetTitles = array('One', 'Two', 'Three', 'Four', 'Five');
		foreach ($assetTitles as $title) {
			$asset = new Asset;
			$asset->title = $title;
			$asset->save();
		}
		$notFound = Asset::titlesNotFound("Eleven\nFour");
		$this->assertCount(1, $notFound);
		$this->assertContains('Eleven', $notFound);
		$this->assertNotContains('Four', $notFound);
	}

	/**
	 * @testdox An asset has an Asset Type.
	 */
	public function type() {
		$type = new AssetType;
		$type->title = 'New Type';
		$type->save();
		$asset = new Asset;
		$asset->title = 'Test';
		$asset->asset_type_id = $type->id;
		$asset->save();
	}

	/**
	 * @testdox Jobs can be attached to an asset.
	 */
	public function jobs() {
		$asset = new Asset();
		$asset->title = 'Test';
		$asset->save();
		$this->assertEquals(0, $asset->jobs()->count());
		$jobType = new JobType;
		$jobType->title = 'Root';
		$jobType->save();
		for ($i = 0; $i < 10; $i++) {
			$job = new Job();
			$job->job_type_id = $jobType->id;
			$asset->jobs()->save($job);
		}
		$this->assertEquals(10, $asset->jobs()->count());
	}

}
