<?php

/**
 * chSymfony2FormPluginConfig configuration
 *
 * @package    chSymfony2FormPlugin
 * @subpackage test
 * @author     Fabien Pomerol <fabien.pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-24
 */
$fixtures = 'fixtures.yml';
include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check validation")
    ->get('/validation')

    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'user')
      ->isParameter('action', 'validation')
    ->end()
    ->with('response')->begin()
       ->isStatusCode(200)
        ->checkElement('form input[name="book[name]"]')
    ->end()
    ->click('input.primary', array('book' => array(
        'name' => 'test',
      )
    ))
    ->with('response')->begin()
      ->isStatusCode(200)
      ->checkElement('li:contains("This value is too short. It should have 10 characters or more")', true)
    ->end()
    ->click('input.primary', array('book' => array(
        'name' => 'imareallybigbooknameandnormalytherewillbeanerrorwhenyouwillsubmitme',
      )
    ))
    ->with('response')->begin()
      ->isStatusCode(200)
      ->checkElement('li:contains("This value is too long. It should have 30 characters or less")', true)
    ->end()
    ->click('input.primary', array('book' => array(
        'name' => 'ImANormalTitle',
      )
    ))
    ->with('response')->isRedirected()
    ->followRedirect()
    ->with('request')->begin()
      ->isParameter('module', 'user')
      ->isParameter('action', 'index')
    ->end()
  ;
