<?php

use Amsys\Model\Asset;
use Amsys\Model\AssetType;
use Amsys\Model\Job;

class AssetTypesTest extends TestCase {

	/**
	 * @testdox An Asset Type has a title and can be set as the default for new Assets.
	 */
	public function basic() {
		$type = new AssetType;
		$type->title = 'Test';
		$type->save();
		$this->assertNotNull($type->title);
		$this->assertNotNull($type->is_default);
	}
	/**
	 * @testdox If no Asset Types exist yet, and one is created, that one will be the default.
	 * @test
	 */
	public function defaultType() {
		$type1 = new AssetType();
		$type1->title = 'One';
		$type1->save();
		$this->assertTrue($type1->is_default);
	}

	/**
	 * @testdox Only one Asset Type can be default at any one time.
	 * @test
	 */
	public function onlyOneDefault() {
		// The first one should be default.
		$type1 = new AssetType();
		$type1->title = 'One';
		$type1->save();
		$this->assertTrue($type1->is_default);

		// The second should not.
		$type2 = new AssetType();
		$type2->title = 'Two';
		$type2->save();
		$this->assertFalse($type2->is_default);

		// The third should be after it is created so.
		$type3 = new AssetType();
		$type3->title = 'Three';
		$type3->is_default = true;
		$type3->save();
		$this->assertTrue($type3->fresh()->is_default);

		// But the others shouldn't be.
		$this->assertFalse($type1->fresh()->is_default);
		$this->assertFalse($type2->fresh()->is_default);
		$this->assertEquals(1, AssetType::where('is_default', '=', true)->count());
	}

}
