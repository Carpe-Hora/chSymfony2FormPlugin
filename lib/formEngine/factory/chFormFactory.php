<?php

/**
 * This file declare the chFormFactory class.
 *
 * @package chSymfony2FormPlugin
 * @subpackage factory
 * @author Fabien Pomerol <fabien_pomerol@carpe_hora.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-23
 */

namespace chSymfony2FormPlugin\lib\formEngine\factory;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\ConstraintValidatorFactory;

/**
 * Return an instance of the chFormFactory
 **/
class chFormFactory
{

  private static $factoryInstance;

  public static function getFactoryInstance()
  {
    if (!self::$factoryInstance)
    {
      self::$factoryInstance = new FormFactory(array(
      new CoreExtension(),
      // validation
      new ValidatorExtension(
        new Validator(
          new ClassMetadataFactory(
            new StaticMethodLoader()
            ),
          new ConstraintValidatorFactory()
          )
        )
      ));
    }
    return self::$factoryInstance;
  }
}

