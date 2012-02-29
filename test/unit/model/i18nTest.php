<?php

use chSymfony2FormPlugin\lib\formEngine\translator\translatorFactory;
/**
 * chSymfony2FormPluginConfig configuration
 *
 * @package    chSymfony2FormPlugin
 * @subpackage test
 * @author     Fabien Pomerol <fabien.pomerol@gmail.com>
 * @copyright (c) Carpe Hora SARL 2012
 * @since 2012-02-24
 */

include dirname(__FILE__).'/../../bootstrap/unit.php';

$t = new lime_test(6);

$sfFileSystem = new sfFileSystem();
$t->comment('Assert getDefaultTranslator always return Translator');
$translator = new translatorFactory('fr', 'user');
$t->is(get_class($translator->getDefaultTranslator()), 'Symfony\Component\Translation\Translator', 'return instance of translator');
$t->is(get_class($translator->getTranslator()), 'Symfony\Component\Translation\Translator', 'return instance of translator');

$sfFileSystem->execute(sprintf('cp %s %s', realpath(__DIR__.'/../../fixtures/project/data/i18n/form.xml'), realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/').'/form.xml'));
$t->is($translator->findTranslationResource(), realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/form.xml'), 'validate existing xml translation resource in project');
$t->is(get_class($translator->getTranslator()), 'Symfony\Component\Translation\Translator', 'return instance of translator');
$sfFileSystem->execute(sprintf('rm %s', realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/').'/form.xml'));

$sfFileSystem->execute(sprintf('cp %s %s', realpath(__DIR__.'/../../fixtures/project/data/i18n/form.yml'), realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/').'/form.yml'));
$t->is($translator->findTranslationResource(), realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/form.yml'), 'validate existing yml translation resource in project');
$t->is(get_class($translator->getTranslator()), 'Symfony\Component\Translation\Translator', 'return instance of translator');
$sfFileSystem->execute(sprintf('rm %s', realpath(__DIR__.'/../../fixtures/project/apps/frontend/i18n/fr/').'/form.yml'));
