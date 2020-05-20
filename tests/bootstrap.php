<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * TestClass to place utility functions in.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{

}

class A
{

}

class B
{

}

class C implements Countable
{
    public function count()
    {
        return 0;
    }
}
