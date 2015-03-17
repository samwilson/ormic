<?php namespace Ormic;

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
            $metafile = $dir . '/module.json';
            $meta = new \stdClass();
            $meta->disabled = false;
            if (file_exists($metafile)) {
                $meta = json_decode(file_get_contents($metafile));
            }
            if (!$meta->disabled) {
                $this->modules[$moduleName] = 'modules/' . $moduleName;
            }
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
            $files = $this->fs->glob(app_path() . "/../$dir/$filepath");
            $out = array_merge($out, $files);
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
    public function getModels($fullClass = false)
    {
        $out = array();

        // First get the core model classes.
        foreach ($this->fs->files(app_path() . "/Model") as $f) {
            $className = $this->classNameFromFile($f, $fullClass);
            $out[$className] = '';
        }

        // Then get the modules' model classes.
        foreach ($this->getAll() as $name => $path) {
            foreach ($this->fs->files(app_path() . "/../$path/Model") as $f) {
                $className = $this->classNameFromFile($f, $fullClass);
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

    private function classNameFromFile($filename, $full = false)
    {
        $basePath = dirname(app_path());
        //$baseClass = substr(basename($filename), 0, -4);
        $moduleName = 'x';
        $className = substr(realpath($filename), strlen($basePath) + 1, -4);
        if (starts_with($className, 'app')) {
            $className = substr($className, 4);
        }
        $className = 'Ormic\\' . $className;
        return ($full) ? $className : basename($className);
    }
}
