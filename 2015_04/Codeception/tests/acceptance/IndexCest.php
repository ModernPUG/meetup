<?php
use \AcceptanceTester;

class IndexCest
{
    public function checkNotLogin(AcceptanceTester $I)
    {
        $I->wantTo('/로 접근시 로그인 안되어 있으면 /login.php로 이동');
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/login.php');
    }

    public function checkLoggedIn(AcceptanceTester $I)
    {
        $I->wantTo('/로 접근시 로그인 되어 있으면 /home.php 로 이동');
        $I->amOnPage('/login.php');
        $I->fillField('username', 'lhs');
        $I->fillField('password', '123');
        $I->click('login');
        $I->amOnPage('/');
        $I->seeInCurrentUrl('/home.php');
    }

    public function checkLoggedInRefactored(AcceptanceTester $I)
    {
        TestCommons::logMeIn($I);

        $I->amOnPage('/');
        $I->seeInCurrentUrl('/home.php');
    }
}