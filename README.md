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

Then enable *chSymfony2Form* in your application:

```yml
# app/{your_app}/config/settings.yml

    enabled_modules:
      - chSymfony2Form
```

Then install vendors with:

```bash
    php bin/vendors install
```

### Create some forms




TODO
----

* Refactored the FormEngine, too much code to write in a controller to deal with sf2 forms
* Add more translation ressources types (now just supported yaml and xliff resources)
* Add upload file support?
