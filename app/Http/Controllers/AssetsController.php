<?php

namespace Amsys\Http\Controllers;

use Amsys\Model\Asset;
use Amsys\Model\AssetType;

class AssetsController extends Controller {

	public function index() {
		$view = \View::make('assets.index');
		$view->assets = Asset::get();
		return $view;
	}

	public function create() {
		$view = \View::make('assets/form');
		$view->asset = new Asset();
		$view->asset_types = AssetType::get();
		return $view;
	}

	public function edit($id) {
		$view = \View::make('assets/form');
		$view->asset = Asset::find($id);
		$view->asset_types = AssetType::get();
		return $view;
	}

	public function show($id) {
		$view = \View::make('assets/show');
		$view->asset = Asset::find($id);
		$view->title = 'Asset #' . $id;
		$view->subtitle = $view->asset->title;
		return $view;
	}

	public function store() {
		if (isset($_POST['id'])) {
			$asset = Asset::get($_POST['id']);
		} else {
			$asset = new Asset;
		}
		$asset->title = $_POST['title'];
		$asset->save();
		return redirect()->route('asset.show', [$asset->id]);
	}

}
