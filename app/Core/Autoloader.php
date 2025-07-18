<?php

namespace App\Core;


class Autoloader
{
    private $prefixes = [];
    private $debug = false;
    private $loadedClasses = [];

    public function __construct($debug = false)
    {
        $this->debug = $debug;
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
        // Check if class is already loaded
        if (isset($this->loadedClasses[$class])) {
            return $this->loadedClasses[$class];
        }

        if ($this->debug) {
            error_log("Autoloader: Attempting to load class: $class");
        }

        $prefix = $class;

        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);

            $mappedFile = $this->loadMappedFile($prefix, $relativeClass);
            if ($mappedFile) {
                $this->loadedClasses[$class] = $mappedFile;
                if ($this->debug) {
                    error_log("Autoloader: Successfully loaded class: $class from $mappedFile");
                }
                return $mappedFile;
            }

            $prefix = rtrim($prefix, '\\');
        }

        if ($this->debug) {
            error_log("Autoloader: Failed to load class: $class");
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

    /**
     * Get all registered namespaces
     */
    public function getNamespaces()
    {
        return $this->prefixes;
    }

    /**
     * Get all loaded classes
     */
    public function getLoadedClasses()
    {
        return $this->loadedClasses;
    }

    /**
     * Enable or disable debug mode
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
    }

    /**
     * Check if a class can be autoloaded
     */
    public function canLoadClass($class)
    {
        $prefix = $class;

        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);

            if (isset($this->prefixes[$prefix])) {
                foreach ($this->prefixes[$prefix] as $baseDir) {
                    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
                    if (file_exists($file)) {
                        return $file;
                    }
                }
            }

            $prefix = rtrim($prefix, '\\');
        }

        return false;
    }

    /**
     * Get autoloader statistics
     */
    public function getStats()
    {
        return [
            'registered_namespaces' => count($this->prefixes),
            'loaded_classes' => count($this->loadedClasses),
            'debug_mode' => $this->debug,
            'namespaces' => array_keys($this->prefixes)
        ];
    }
}