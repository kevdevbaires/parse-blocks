<?php

namespace CNET\Bridge;

/**
 * Project auto-loader
 *
 * @package CNET\Bridge
 */
class Autoloader {

    /**
     * Autoloader for project
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
    public static function load($class_name) {
        if (str_starts_with($class_name, __NAMESPACE__)) {
            $base     = __DIR__ . '/application';
            $relative = str_replace([__NAMESPACE__, '\\'], ['', '/'], $class_name);
            $relative_kebab = str_replace('_', '-', strtolower($relative));
            $filename = $base . $relative_kebab . '.php';
        }

        if (!empty($filename) && file_exists($filename)) {
            require $filename;
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
    private static function instantiate_class($class_name) {
        try {
            $reflection_class = new \ReflectionClass($class_name);
            $instance = $reflection_class->newInstance();
        } catch (\ReflectionException $e) {
            error_log('Error instantiating class: ' . $e->getMessage());
        }
    }

    /**
     * Autoload and instantiate all classes within a namespace
     *
     * @param string $namespace
     *
     * @return void
     *
     * @access public
     * @static
     */
    public static function load_blocks() {
        $namespace = __NAMESPACE__ . '\Blocks';

        $directory = __DIR__ . '/application/blocks';
        $files = glob($directory . '/*.php');

        if ($files) {
            foreach ($files as $file) {
                require_once $file;

                $basename = basename($file, '.php');

                $class_name_formatted = ucwords(str_replace('-', '_', $basename), '_');

                $class_name = $namespace . "\\" . $class_name_formatted;

                if (class_exists($class_name)) {
                    self::instantiate_class($class_name);
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
    public static function register() {
        spl_autoload_register(__CLASS__ . '::load');
    }

}

if (defined('ABSPATH')) {
    Autoloader::register();
    Autoloader::load_blocks();
}
