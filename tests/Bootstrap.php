<?php

class TestBootstrap
{
    private static $autoloaderFiles = [
        '../vendor/autoload.php',
    ];

    private static $application;

    /**
     * Setup the testing environment.
     *
     * @param  string $config Path to the Zend application config file.
     * @return void
     */
    public static function init($config)
    {
        $loader = self::getAutoloader();

        $loader->add('SclZfCartTests\\', __DIR__);

        self::$application = \Zend\Mvc\Application::init($config);
    }

    /**
     * Return the application instance.
     *
     * @return \Zend\Mvc\Application
     */
    public static function getApplication()
    {
        return self::$application;
    }

    public static function getEntityManager()
    {
        return self::$application
                   ->getServiceManager()
                   ->get('doctrine.entitymanager.orm_default');
    }

    private static function getAutoloader()
    {
        global $loader;

        foreach (self::$autoloaderFiles as $file) {
            if ($file[1] !== '/') {
                $file = __DIR__ . '/' . $file;
            }


            if (file_exists($file)) {
                $loader = include $file;

                break;
            }
        }

        if (!isset($loader) || !$loader) {
            throw new \RuntimeException('vendor/autoload.php not found. Have you run composer?');
        }

        return $loader;
    }
}

TestBootstrap::init(include __DIR__ . '/application.config.php');
