<?php

namespace Amsys\Http\Controllers;

use Amsys\Model\Asset;
use Amsys\Model\AssetType;
use Amsys\Model\Job;
use Amsys\Model\JobType;

class JobsController extends Controller {

	public function create() {
		$asset = (isset($_GET['asset'])) ? Asset::find($_GET['asset']) : new Asset;
		$view = view('jobs.form');
		$view->title = 'Create Job';
		$view->asset = $asset;
		$view->job = new Job;
		$view->job_types = JobType::get();
		return $view;
	}

	public function store() {
		if (isset($_POST['id'])) {
			$job = Job::get($_POST['id']);
		} else {
			$job = new Job;
		}
		$job->asset_id = $_POST['asset_id'];
		$job->job_type_id = $_POST['job_type_id'];
		$job->save();
		return redirect()->route('asset.show', [$job->asset->id]);
	}

}
