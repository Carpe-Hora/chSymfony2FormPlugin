<?php

/**
 * @author Fabien Pomerol <fabien_pomerol@carpe_hora.com>
 * @company Carpe Hora SARL
 **/

use symfony2Form\Type\UserType;
use chSymfony2FormPlugin\lib\formEngine\templating\formTemplateEngine;
use chSymfony2FormPlugin\lib\formEngine\factory\chFormFactory;

class userActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    //first we create a new form with a given form type
    $formFactory = chFormFactory::getFactoryInstance();

    $form = $formFactory->create(new UserType());

    //then we create the template engine
    $formTemplateEngine = new FormTemplateEngine($this->getUser()->getCulture(), $this->context->getModuleName());
    $this->formHelper = $formTemplateEngine->getFormHelper();

    if ($request->getMethod() == "POST")
    {
      $formValues = $request->getParameter($form->getName());
      if (isset($formValues))
      {
        $form->bind($formValues);
        if ($valid = $form->isValid())
        {
          //gonna put some stuff here!
          $this->redirect('/');
        }
      }
    }

    sfConfig::set('sf_escaping_strategy', false);
    $this->formView = $form->createView();
  }

}

