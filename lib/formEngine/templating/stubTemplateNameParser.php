<?php

/**
 * This file declare the StubTemplateNameParser class
 *
 * @package chFormEngine
 * @subpackage Templating
 * @author Fabien Pomerol <fabien_pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-23
 */

namespace chSymfony2FormPlugin\lib\formEngine\templating;

use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\TemplateNameParserInterface;

/**
 * Template name parser
 * @see Symfony\Bundle\FrameworkBundle\Tests\Templating\Helper\Fixtures\StubTemplateNameParser
 *
 * Needed to load the templates used for rendering form items.
 */
class stubTemplateNameParser implements TemplateNameParserInterface
{
    private $root;

    private $rootTheme;

    public function __construct($root, $rootTheme)
    {
        $this->root = $root;
        $this->rootTheme = $rootTheme;
    }

    public function parse($name)
    {

      list($bundle, $controller, $template) = explode(':', $name);

      if ($template[0] == '_') {
          $path = $this->rootTheme.'/Custom/'.$template;
      } elseif ($bundle === 'TestBundle') {
          $path = $this->rootTheme.'/'.$controller.'/'.$template;
      } else {
          $path = $this->root.'/'.$controller.'/'.$template;
      }

      return new TemplateReference($path, 'php');
    }
}
