<?php
use \AcceptanceTester;

class LoginCest
{
    public function checkLogin(AcceptanceTester $I)
    {
        $I->wantTo('로그인');
        $I->amOnPage('/login.php');
        $I->fillField('username', 'lhs');
        $I->fillField('password', '123');
        $I->click('login');
        $I->seeInCurrentUrl('/home.php');
    }
}