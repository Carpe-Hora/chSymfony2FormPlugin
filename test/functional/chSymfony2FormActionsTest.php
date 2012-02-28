<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check default config")
    ->get('/user/index')

    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'user')
      ->isParameter('action', 'index')
    ->end()
;
