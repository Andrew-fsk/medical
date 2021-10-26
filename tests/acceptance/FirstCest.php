<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
        $I->amOnPage('/substance');
        $I->see('substance');
        $I->amOnPage('/substance');
        $I->see('substance');
        $I->amOnPage('/manufacturer');
        $I->see('manufacturer');
    }
}
