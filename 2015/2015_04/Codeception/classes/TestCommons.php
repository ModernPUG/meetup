<?php 
class TestCommons {
    public static function logMeIn($I)
    {
        $I->wantTo('로그인');
        $I->amOnPage('/login.php');
        $I->fillField('username', 'lhs');
        $I->fillField('password', '123');
        $I->click('login');
    }

    public static function SignMeIn($I)
    {
        $I->amOnPage('/');
        $I->amOnPage('/login.php');
        $I->seeLink('sign in');
        $I->click('sign in');
        $I->seeInCurrentUrl('/signin.php');
        $I->fillField('email', 'test1@example.com');
        $I->fillField('username', 'test1');
        $I->fillField('password', 'test1');
        $I->click('sign in');
    }
}