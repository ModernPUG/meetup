<?php
use \ApiTester;

class GetSiteInfoCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function missingAccessToken(ApiTester $I)
    {
        $I->wantTo('파라미터를 넣지 않아 api를 통한 사이트 정보 조회에 실패');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('siteinfo.php', []);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Missing Parameter');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('siteinfo.php', ['userId' => 'testUser']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Missing Parameter');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('siteinfo.php', ['accessToken' => 'testAccessToken']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Missing Parameter');
    }

    public function invalidAccessToken(ApiTester $I)
    {
        $I->wantTo('틀린 accessToken을 입력하여 api를 통한 사이트 정보 조회에 실패');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('siteinfo.php', ['userId' => 'testUser', 'accessToken' => 'invalidAccessToken']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Access Token');
    }

    public function getSiteinfo(ApiTester $I)
    {
        $I->wantTo('api를 통한 사이트 정보 조회');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('siteinfo.php', ['userId' => 'testUser', 'accessToken' => 'testAccessToken']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Modern PHP');
    }
}