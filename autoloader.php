<?php

namespace Cnet\ParseBlocks;

/*
 * Initial autoloader, this is the one to use when
 * files are on the /application folder
 * */
class Autoloader {

    public static function load($class_name) {

        if (strpos($class_name, __NAMESPACE__) === 0) {
            $base     = __DIR__ . '/application';
            $relative = str_replace([__NAMESPACE__, '\\'], ['', '/'], $class_name);
            $filename = $base . $relative . '.php';
        }

        if (!empty($filename) && file_exists($filename)) {
            require($filename);
        }
    }

    public static function register() {
        spl_autoload_register(__CLASS__ . '::load');
    }

}

//Autoloader::register();


/*
 * Testing autoloader when having multiple
 * directories
 *
 * */
class AutoloaderTest {
	private $path;
	private $namespace;
	public function __construct($path) {
		$this->path = $path;
		$this->namespace = __NAMESPACE__;

		spl_autoload_register([$this, 'load']);
	}

	function load($className) {
		if (strpos($className, $this->namespace) === 0) {
            $base     = __DIR__ . $this->path;
            $relative = str_replace([__NAMESPACE__, '\\'], ['', '/'], $className);
            $filename = $base . $relative . '.php';
			
        }

		if (!empty($filename) && file_exists($filename)) {
			require($filename);

			if ($this->path == '/blocks'){
				call_user_func($className . '::bootstrap');
			}
		}
	}
}

$autoloader_app = new AutoloaderTest('/application');
$autoloader_blocks = new AutoloaderTest('/blocks');