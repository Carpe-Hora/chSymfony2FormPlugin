<?php
/**
 * This file declare the translatorFactory class.
 *
 * @package chSymfony2FormPlugin
 * @subpackage translator
 * @author Fabien Pomerol <fabien_pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-27
 */

namespace chSymfony2FormPlugin\lib\formEngine\translator;

use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;

/**
 * Load the right translation file
 */
class translatorFactory
{

  protected $allowedTypes = array('xml', 'yml');

  protected $locale;

  protected $type;

  protected $currentModule;

  /**
   * Default constructor
   *
   * @param String $locale        the current user locale
   * @param String $currentModule the current user module name
   *
   **/
  public function __construct($locale, $currentModule)
  {
    $this->locale        = $locale;
    $this->currentModule = $currentModule;
  }

  /**
   * Return a default Translator
   *
   * @return Validator a well formated validator
   *
   **/
  public function getDefaultTranslator()
  {
    $translator = new Translator($this->locale, new MessageSelector());

    return $translator;
  }

  /**
   * Return a translator based on a XML resource file
   *
   * @return Translator a well formated translator
   *
   **/
  public function getXliffFileLoader()
  {
    $xliffFileLoader = new XliffFileLoader();
    $xliffFileLoader->load($this->resourcePath, $this->locale);

    $translator = $this->getDefaultTranslator();
    $translator->addLoader('xliff', $xliffFileLoader);
    $translator->addResource('xliff', $this->resourcePath, $this->locale);

    return $translator;
  }

  /**
   * Return a translator based on a YAML resource file
   *
   * @return Translator a well formated translator
   *
   **/
  public function getYamlFileLoader()
  {
    $yamlFileLoader = new YamlFileLoader();
    $yamlFileLoader->load($this->resourcePath, $this->locale);

    $translator = $this->getDefaultTranslator();
    $translator->addLoader('yaml', $yamlFileLoader);
    $translator->addResource('yaml', $this->resourcePath, $this->locale);

    return $translator;
  }

  /**
   * Return a well formated translator for a specific resource type
   * The resource type is based on the resource file extension
   *
   * @return Translator the well formated translator
   *
   **/
  public function getTranslatorByResourceExtension()
  {
    $this->type =  pathinfo($this->resourcePath, PATHINFO_EXTENSION);

    if (in_array($this->type, $this->allowedTypes))
    {
      switch ($this->type)
      {
        case 'xml':
          return $this->getXliffFileLoader();
          break;
        case 'yml':
          return $this->getYamlFileLoader();
          break;
      }
    }
    else
    {
      throw new \Exception('Unknow translation resource type');
    }
  }

  /**
   * Find in the translation resource in the project tree
   * The search is based on the translation_resource_name given in the app.yml file
   * In a first time it look in the i18n directory of the current module
   * In a second time it look in the i18n directory of the current application
   *
   * @return mixed  the resource's path | null
   *
   **/
  public function findTranslationResource()
  {
    $resourceName = \sfConfig::get('app_symfony2_form_plugin_translation_resource_name');
    $i18nAppDir = \sfConfig::get('sf_app_i18n_dir');
    $appModuleDir= \sfConfig::get('sf_app_module_dir');

    foreach ($this->allowedTypes as $type)
    {
      //check if the translation ressource exist under the apps/<app>/modules/<module>/i18n/<locale> dir
      if(file_exists($appModuleDir.'/'.$this->currentModule.'/i18n/'.$this->locale.'/'.$resourceName.'.'.$type))
      {
        return $appModuleDir.'/'.$this->currentModule.'/i18n/'.$this->locale.'/'.$resourceName.'.'.$type;
      }
      //check if the translation ressource exist under the apps/<app>/i18n/<locale> dir
      else if (file_exists($i18nAppDir.'/'.$this->locale.'/'.$resourceName.'.'.$type))
      {
        return $i18nAppDir.'/'.$this->locale.'/'.$resourceName.'.'.$type;
      }
    }

    return null;
  }

  /**
   * Return a translator by guessing the existing resource file
   *
   * @return Translator a weel formated translator
   *
   **/
  public function getTranslator()
  {
    $this->resourcePath = $this->findTranslationResource();

    if($this->resourcePath)
    {
      return $this->getTranslatorByResourceExtension();
    }
    else
    {
      return $this->getDefaultTranslator();
    }
  }
}
