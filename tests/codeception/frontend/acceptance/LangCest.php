<?php
namespace tests\codeception\frontend;

use tests\codeception\frontend\AcceptanceTester;

class LangCest
{
    /**
     * @env php
     */
    public function testI18nSourceLang(AcceptanceTester $I)
    {
        $I->wantTo('test i18n on source language page');
        $I->amOnPage('/');
        $I->see('Radiata CMS. ' . date("Y"), '#copyright');
    }

    /**
     * @env php
     */
    public function testI18nNotSourceLang(AcceptanceTester $I)
    {
        $I->wantTo('test i18n on other than source language page');
        $I->amOnPage('/ru');
        $I->see('Radiata CMS. ' . date("Y") . ' год', '#copyright');
    }

    /**
     * @env php
     */
    public function testlanguageSwitcher(AcceptanceTester $I)
    {
        $I->wantTo('test language switcher');
        $I->amOnPage('/');
        $I->click(['link' => 'ru']);
        $I->seeCurrentUrlEquals('/index-test.php/ru');
    }
}
