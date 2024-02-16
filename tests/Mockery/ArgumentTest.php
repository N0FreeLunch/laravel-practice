<?php
/**
 * php artisan test tests/Mockery/ArgumentTest.php
 */

use \Mockery\Adapter\Phpunit\MockeryTestCase;

class ArgumentTest extends MockeryTestCase
{
    public function testArgument()
    {
        $arg = 'bar';
        $returnValue = 'foobar';
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('foo')
            ->once()
            ->with($arg)
            ->andReturn($returnValue);

        $this->assertEquals($mock->foo($arg), $returnValue);
        // $this->assertEquals($mock->foo($arg), $returnValue);
    }
}
