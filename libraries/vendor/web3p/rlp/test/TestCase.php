<?php

namespace Test;

use \PHPUnit\Framework\TestCase as BaseTestCase;
use Web3p\RLP\RLP;

class TestCase extends BaseTestCase
{
    /**
     * rlp
     * 
     * @var \RLP\RLP
     */
    protected $rlp;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        $this->rlp = new RLP;
    }

    /**
     * tearDown
     * 
     * @return void
     */
    public function tearDown() {}
}