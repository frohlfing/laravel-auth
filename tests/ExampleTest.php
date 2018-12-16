<?php

class FeedTest extends Orchestra\Testbench\TestCase
{
    protected $foo;

    public function setUp()
    {
        parent::setUp();
        $this->foo = 'bar';
    }

    public function testFoo()
    {
        $this->assertEquals('bar', $this->foo);
    }
}