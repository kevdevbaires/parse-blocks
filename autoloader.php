<?php


namespace CNET\Bridge;

use ReflectionClass;

/**
 * Project auto-loader
 *
 * @package CNET\Bridge
 */
class Autoloader
{

    /**
     * Auto-loader for project
     *
     * Try to load a class within the same namespace
     *
     * @param string $class_name
     *
     * @return void
     *
     * @access public
     * @static
     */
    public static function load($class_name)
    {
        if (str_starts_with($class_name, __NAMESPACE__)) {
            $base     = __DIR__ . '/application';
            $relative = str_replace([__NAMESPACE__, '\\'], ['', '/'], $class_name);
            $filename = $base . $relative . '.php';
        }

        if (!empty($filename) && file_exists($filename)) {
            require($filename);
        }
    }

    /**
     * Instantiate a class using reflection
     *
     * @param string $class_name
     *
     * @return void
     *
     * @access private
     * @static
     */
    private static function instantiateClass($class_name)
    {
        try {
            $reflectionClass = new \ReflectionClass($class_name);
            $instance = $reflectionClass->newInstance();
        } catch (\ReflectionException $e) {
            error_log('Error instantiating class: ' . $e->getMessage());
        }
    }

    /**
     * Auto-load and instantiate all classes within a namespace
     *
     * @param string $namespace
     *
     * @return void
     *
     * @access public
     * @static
     */
    public static function loadBlocks()
    {
        $namespace = __NAMESPACE__ . '\Blocks';

        $directory = __DIR__ . '/application/blocks';
        $files = glob($directory . '/*.php');
        if ($files !== false) {
            foreach ($files as $file) {
                require_once $file;

                $class_name = $namespace . "\\" .basename($file, '.php');

                if (class_exists($class_name)) {
                    self::instantiateClass($class_name);
                }
            }
        }
    }

    /**
     * Register auto-loader
     *
     * @return void
     *
     * @access public
     * @static
     */
    public static function register()
    {
        spl_autoload_register(__CLASS__ . '::load');
    }

}

if (defined('ABSPATH')) {
    Autoloader::register();
    Autoloader::loadBLocks();
}
