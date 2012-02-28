<?php

/**
 * FormTemplateEngine initialize the template engine
 *
 * @package chSymfony2FormPlugin
 * @subpackage templating
 * @author Fabien Pomerol <fabien_pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-23
 */

namespace chSymfony2FormPlugin\lib\formEngine\templating;

use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use chSymfony2FormPlugin\lib\formEngine\templating\stubTemplateNameParser;
use chSymfony2FormPlugin\lib\formEngine\translator\translatorFactory;

class formTemplateEngine
{

  protected $engine;

  protected $locale;

  protected $translationResource;

  protected $currentModule;

  public function __construct($locale = 'en', $currentModule = null)
  {
    $this->locale        = $locale;
    $this->currentModule = $currentModule;
  }

  /**
   * Initialize the php template engine
   *
   * @return PhpEngine the php template engine
   *
   **/
  public function initializeEngine()
  {
    $root = realpath(__DIR__ . '/../../../vendor/Symfony/Bundle/FrameworkBundle/Resources/views');
    $rootTheme = realpath(__DIR__ . '/../../vendor/Symfony/Bundle/FrameworkBundle/Resources');

    $templateNameParser = new StubTemplateNameParser($root, $rootTheme);
    $loader = new FilesystemLoader(array());

    $this->engine = new PhpEngine($templateNameParser, $loader);
  }

  /**
   * Return a form helper well formed included translator helper
   *
   * @return FormHelper $formHelper the formHelper
   *
   **/
  public function getFormHelper()
  {
    $this->initializeEngine();

    //the crsf provider
    $csrfProvider = new DefaultCsrfProvider(\sfConfig::get('app_symfony2_form_secret'));

    $translatorFactory = new translatorFactory($this->locale, $this->currentModule);
    $translator = $translatorFactory->getTranslator();

    $formHelper = new FormHelper($this->engine, $csrfProvider, array(
        'FrameworkBundle:Form',
        )
    );

    $this->engine->setHelpers(array(
      $formHelper,
      new TranslatorHelper($translator),
    ));

    return $formHelper;
  }

}
