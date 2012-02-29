<?php

if (!isset($_SERVER['SYMFONY']))
{
  $_SERVER['SYMFONY'] = '../../lib/vendor/symfony/lib/';
}

if (!isset($app))
{
  $app = 'frontend';
}

if (!isset($rootdir))
{
  $rootdir = dirname(__FILE__).'/../fixtures/project/';
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

function chSymfony2FormPlugin_cleanup()
{
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/cache');
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/log');
}
chSymfony2FormPlugin_cleanup();
register_shutdown_function('chSymfony2FormPlugin_cleanup');

require_once dirname(__FILE__).'/../fixtures/project/config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true, $rootdir);
sfContext::createInstance($configuration);

$configuration->initializePropel($app);
if (isset($fixtures))
{
  $configuration->loadFixtures($fixtures);
}
