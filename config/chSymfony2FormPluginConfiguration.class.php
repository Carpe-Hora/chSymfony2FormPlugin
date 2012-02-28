<?php

/**
 * chSymfony2FormPluginConfig configuration
 *
 * @package    chSymfony2FormPlugin
 * @subpackage config
 * @author     Fabien Pomerol <fabien.pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-24
 */

//namespace chSymfony2FormPlugin\config;

class chSymfony2FormPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';
  /**
  * @see sfPluginConfiguration
  */
  public function initialize()
  {
    spl_autoload_register(array($this, 'autoloadNamespace'));
  }

  public function autoloadNamespace($className)
  {

    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\'))
    {
      $namespace = substr($className, 0, $lastNsPos);
      $className = substr($className, $lastNsPos + 1);
      $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    foreach(array(
      realpath(dirname(__FILE__).'/../../'. DIRECTORY_SEPARATOR . $fileName . $className . '.php'),
      realpath(dirname(__FILE__).'/../vendor/'. DIRECTORY_SEPARATOR . $fileName . $className . '.php'),
      sfConfig::get('sf_lib_dir').'/'. DIRECTORY_SEPARATOR . $fileName . $className . '.php',
      ) as $fileName)
    {
      if (file_exists($fileName))
      {
        require $fileName;
        return true;
      }
    }
    return false;
  }



}
