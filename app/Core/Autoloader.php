<?php
namespace App\Core;
class Autoloader
{
    private $prefixes = [];
    public function __construct()
    {
        $this->addNamespace('App', ROOT_PATH . '/app');
    }
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }
    public function addNamespace($prefix, $baseDir)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
        if (!isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = [];
        }
        array_push($this->prefixes[$prefix], $baseDir);
    }
    public function loadClass($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);
            $mappedFile = $this->loadMappedFile($prefix, $relativeClass);
            if ($mappedFile) {
                return $mappedFile;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }
    protected function loadMappedFile($prefix, $relativeClass)
    {
        if (!isset($this->prefixes[$prefix])) {
            return false;
        }
        foreach ($this->prefixes[$prefix] as $baseDir) {
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            if ($this->requireFile($file)) {
                return $file;
            }
        }
        return false;
    }
    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}