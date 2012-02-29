<?php

/**
 * @author Fabien Pomerol <fabien_pomerol@carpe_hora.com>
 * @company Carpe Hora SARL
 **/

namespace symfony2Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class BookType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
     $builder
       ->add('name', 'text', array(
         'required' => true,
         )
       )
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
