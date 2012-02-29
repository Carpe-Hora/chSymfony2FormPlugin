<?php

/**
 * @author Fabien Pomerol <fabien_pomerol@carpe_hora.com>
 * @company Carpe Hora SARL
 **/

namespace symfony2Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Csrf\Type\CsrfType;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider;

class BookCsrfType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
     $builder
       ->add('name', 'text', array(
         'required' => true,
         )
       )
       ->add('_token', new CsrfType(new SessionCsrfProvider('test', \sfConfig::get('app_symfony2_form_secret'))))

     ;
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Book',
    );
  }

  public function getName()
  {
    return 'book';
  }

}
