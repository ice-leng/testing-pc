<?php


class apiCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->wantTo('登录');
        $I->sendPOST('/login/index', ['access' => 'root', 'password' => '12345']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'code'    => 0,
            'message' => "Success",
        ]);
    }
}
