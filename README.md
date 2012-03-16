chSymfony2FormPlugin: use the Symfony2 Form Component in your symfony 1 applications
==================================================================

Goal
----

[chSymfony2FormPlugin](https://github.com/Carpe-Hora/chSymfony2FormPlugin) is a 
[symfony 1.4](http://www.symfony-project.org/) plugin used to integrate the Symfony2 
Form component into your symfony 1.x applications


How does it work ?
------------------

### Enable

First, enable the plugin in your project configuration:

```php
<?php
// config/ProjectConfiguration.class.php

public function setup()
{
  $this->enablePlugins(array('chSymfony2FormPlugin'));
}
```

Then install vendors with:

```bash
    php bin/vendors install
```

### Create some forms

First we create a new form type

````php
# symfony1Project/lib/symfony2Form/Type/UserType.php
<?php

namespace symfony2Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Csrf\Type\CsrfType;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use symfony2Form\Type\BookType;

class UserType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
     
     $builder
       ->add('firstname', 'text', array(
         'required' => true,
       ))
       ->add('lastname', 'text', array(
         'required' => true,
       ))
       ->add('_token', new CsrfType(new DefaultCsrfProvider(\sfConfig::get('app_symfony2_form_secret'))))
     ;
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'User',
    );
  }

  public function getName()
  {
    return 'user';
  }
}
```

Then we can create a new form in our action

````php
<?php
public function executeIndex(sfWebRequest $request)
{
  //first we create a new form with a given form type
 $formFactory = chFormFactory::getFactoryInstance();

    $user = new User();
    $form = $formFactory->create(new symfony2Form\Type\UserType(), $user);

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
          //do what you want here
        }
      }
    }

    sfConfig::set('sf_escaping_strategy', false);
    $this->formView = $form->createView();
}
```

To add some validation to our User entity we need to add this method

````php
<?php
# <pathToYourModelDir>/User.php
...
public static function loadValidatorMetadata(ClassMetadata $metadata)
{
  $metadata->addPropertyConstraint('firstname', new Constraints\NotBlank());
  $metadata->addPropertyConstraint('firstname', new Constraints\MinLength(10));
  $metadata->addPropertyConstraint('lastname', new Constraints\NotBlank());
  $metadata->addPropertyConstraint('lastname', new Constraints\MinLength(10));
}
...
```

The last step is to render the form in a view.

````php
<!-- indexSuccess.php -->
<form action="<?php echo url_for('user_create'); ?>" method="post"
  <?php echo $formHelper->enctype($formView) ?> novalidate="novalidate">

  <?php echo $formHelper->widget($formView) ?>

  <div class="actions">
   <input type="submit"value="Save" />
  </div>
</form>
```

You can render the form field by field. For example if we want to render the firstname field alone we can do:

````php

<?php 

//will display the label
$formHelper->label($formView['firstname']);
//will display the error
$formHelper->error($formView['firstname']);
//will display the widget alone
$formHelper->widget($formView['firstname']); 

?>
```

TODO
----

* Refactored the FormEngine, too much code to write in a controller to deal with sf2 forms
* Add more translation ressources types (now just supported yaml and xliff resources)
* Add upload file support?
