<?php
/**
 * php artisan test tests/Mockery/UndefinedTest.php
 */

use \Mockery\Adapter\Phpunit\MockeryTestCase;

class UndefinedTest extends MockeryTestCase
{
    public function testUndefinedValues()
    {
        $mock = \Mockery::mock('mymock');
        $mock->shouldReceive('divideBy')->with(0)->andReturnUndefined();
        $this->assertTrue($mock->divideBy(0) instanceof \Mockery\Undefined);
    }
}
