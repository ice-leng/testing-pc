<?php


class htmlCest
{

    //tests
    public function xx(AcceptanceTester $I)
    {
        try{
            $I->wantTo('xx');
            $I->amOnPage('/');
            $I->fillField('username','davert');
            $I->fillField('password','qwerty');
            $I->click('/html[1]/body[1]/div[1]/div[1]/div[2]');
            $I->wait(2);
            $I->see('账号不存在2');
        }catch (Exception $e){
            throw $e;
        }
    }

    //tests
    public function xx2(AcceptanceTester $I)
    {
        try{
            $I->wantTo('xx2');
            $I->amOnPage('/');
            $I->fillField('username','davert');
            $I->fillField('password','qwerty');
            $I->click('/html[1]/body[1]/div[1]/div[1]/div[2]');
            $I->wait(2);
            $I->see('账号不存在2');
        }catch (Exception $e){
            throw $e;
        }
    }
}
