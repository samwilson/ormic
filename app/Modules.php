<?php

namespace Ormic;

use Illuminate\Filesystem\Filesystem;

class Modules
{

    private $modules = array();

    /** @var \Illuminate\Filesystem\Filesystem */
    private $fs;

    public function __construct()
    {
        $this->fs = new Filesystem();
        foreach ($this->fs->directories(app_path() . '/../modules') as $dir) {
            $moduleName = basename($dir);
            $this->modules[$moduleName] = 'modules/' . $moduleName;
        }
    }

    /**
     * Get an array of paths to a given file.
     * @param type $path
     */
    public function files($filepath)
    {
        $out = array();
        foreach ($this->modules as $dir) {
            dd($dir . '/' . $filepath);
            $out = array_merge($out, $this->fs->glob($dir . '/' . $filepath));
        }
        return $out;
    }

    public function getAll()
    {
        return $this->modules;
    }

    /**
     * Get an array of class names of all models.
     *
     * @return array|string Array of class name to module name.
     */
    public function getModels()
    {
        $out = array();

        // First get the core model classes.
        foreach ($this->fs->files(app_path() . "/Model") as $f) {
            $className = $this->classNameFromFile($f);
            $out[$className] = ''; //'Ormic\Model\\' . $className;
        }

        // Then get the modules' model classes.
        foreach ($this->getAll() as $name => $path) {
            foreach ($this->fs->files(app_path() . "/../$path/Model") as $f) {
                $className = $this->classNameFromFile($f);
                $out[$className] = basename($path); // 'Ormic\\' . studly_case($name) . '\Model\\' . $className;
            }
        }

        return $out;
    }

    /**
     * Get the name of the module that provides a given model.
     * @param string $modelName
     * @return string|false
     */
    public function getModuleOfModel($modelName)
    {
        foreach ($this->getModels() as $model => $module) {
            if ($modelName == $model) {
                return basename($module);
            }
        }
        return false;
    }

    private function classNameFromFile($filename)
    {
        return substr(basename($filename), 0, -4);
    }
}
