<?php

/**
 * @author Fabien Pomerol <fabien_pomerol@carpe_hora.com>
 * @company Carpe Hora SARL
 **/

namespace symfony2Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class UserType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
     $builder
       ->add('text', 'text', array(
         'required' => true,
         )
       )
       ->add('textarea', 'textarea')
       ->add('integer', 'integer')
       ->add('money', 'money')
       ->add('number', 'number')
       ->add('password', 'password')
       ->add('email', 'email', array(
         'required' => true,
         )
       )
       ->add('percent', 'percent')
       ->add('search', 'search')
       ->add('url', 'url')
       ->add('choice', 'choice', array(
         'choices' => array(
           '1' => 'Man',
           '2' => 'Woman'
         )
       ))
       ->add('timezone', 'timezone')
       ->add('date', 'date')
       ->add('datetime', 'datetime')
       ->add('time', 'time')
       ->add('birthday', 'birthday')

       ->add('checkbox', 'checkbox', array(
        'label' => 'check my checkbox',
       ))
       ->add('file', 'file')
       ->add('radio', 'radio', array(
        'label' => 'check my radio',
       ))
       ->add('repeated', 'repeated')
       ->add('hidden', 'hidden')
     ;
  }

  public function getName()
  {
    return 'user';
  }

}
