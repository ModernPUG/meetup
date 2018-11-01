<?php
use \AcceptanceTester;

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function checkSignin(AcceptanceTester $I)
    {
        TestCommons::SignMeIn($I);

        $I->seeInDatabase('users',['username' => 'test1']);
        $I->seeInCurrentUrl('/home.php');
    }

    public function checkLoginAfterSignin(AcceptanceTester $I)
    {
        TestCommons::SignMeIn($I);

        $I->seeInDatabase('users',['username' => 'test1']);

        $I->amOnPage('/');
        $I->seeInCurrentUrl('/home.php');
    }

    public function checkCantSigninByEmailDuplicate(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->amOnPage('/login.php');
        $I->seeLink('sign in');
        $I->click('sign in');
        $I->seeInCurrentUrl('/signin.php');
        $I->fillField('email', 'naya@example.com');
        $I->fillField('username', 'test2');
        $I->fillField('password', 'test2');
        $I->click('sign in');
        $I->seeInCurrentUrl('/signin.php');
        $I->see('duplicated');
    }
}