<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I


class Acceptance extends Base
{
    public function _afterSuite()
    {
        $this->setTagDir('html');
        parent::_afterSuite();
    }
}
