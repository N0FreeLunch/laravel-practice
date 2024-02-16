<?php
/**
 * php artisan test tests/Mockery/ReturnTimesTest.php
 */

use \Mockery\Adapter\Phpunit\MockeryTestCase;

class ReturnTimesTest extends MockeryTestCase
{
    public function testReturnTimes()
    {
        $mock = \Mockery::mock('MyClass');
        $mock->shouldReceive('foo')
            ->andReturn(1, 2, 3);

        $this->assertEquals($mock->foo(), 1);
        $this->assertEquals($mock->foo(), 2);
        $this->assertEquals($mock->foo(), 3);
        $this->assertEquals($mock->foo(), 3);
        $this->assertEquals($mock->foo(), 3);
    }
}
