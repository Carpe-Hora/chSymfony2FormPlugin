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

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check element rendering")
    ->get('/')

    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'user')
      ->isParameter('action', 'index')
    ->end()
    ->with('response')->begin()
       ->isStatusCode(200)
        ->checkElement('form input[name="user[text]"]')
        ->checkElement('form textarea[name="user[textarea]"]')
        ->checkElement('form input[name="user[money]"]')
        ->checkElement('form input[name="user[integer]"]')
        ->checkElement('form input[name="user[number]"]')
        ->checkElement('form input[name="user[password]"]')
        ->checkElement('form input[name="user[email]"]')
        ->checkElement('form input[name="user[percent]"]')
        ->checkElement('form input[name="user[search]"]')
        ->checkElement('form input[name="user[url]"]')

        ->checkElement('form select[name="user[choice]"]')
        ->checkElement('form select[name="user[timezone]"]')
        ->checkElement('form select[name="user[date][month]"]')
        ->checkElement('form select[name="user[date][day]"]')
        ->checkElement('form select[name="user[date][year]"]')
        ->checkElement('form select[name="user[datetime][date][day]"]')
        ->checkElement('form select[name="user[datetime][date][month]"]')
        ->checkElement('form select[name="user[datetime][date][year]"]')
        ->checkElement('form select[name="user[datetime][time][hour]"]')
        ->checkElement('form select[name="user[datetime][time][minute]"]')
        ->checkElement('form select[name="user[time][minute]"]')
        ->checkElement('form select[name="user[time][minute]"]')
        ->checkElement('form select[name="user[birthday][day]"]')
        ->checkElement('form select[name="user[birthday][month]"]')
        ->checkElement('form select[name="user[birthday][year]"]')

        ->checkElement('form input[name="user[checkbox]"]')
        ->checkElement('form input[type="checkbox"]')
        ->checkElement('form input[name="user[file]"]')
        ->checkElement('form input[type="file"]')
        ->checkElement('form input[name="user"]')
        ->checkElement('form input[type="radio"]')
        ->checkElement('form input[name="user[repeated][first]"]')
        ->checkElement('form input[name="user[repeated][second]"]')
        ->checkElement('form input[name="user[hidden]"]')
        ->checkElement('form input[type="hidden"]')
    ->end();
    file_put_contents(__DIR__.'/test.php',$browser->getResponse()->getContent());

