<?php

namespace Ormic\Http\Controllers;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $this->view->title = 'Welcome';
        $mods = new \Ormic\Modules();
        $this->view->models = $mods->getModels();
        return $this->view;
    }
}
