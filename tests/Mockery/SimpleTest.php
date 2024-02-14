<?php

/**
 * php artisan test tests/Mockery/SimpleTest.php
 */
namespace Tests\Feature\Mockery;

use \Mockery\Adapter\Phpunit\MockeryTestCase;

class SimpleTest extends MockeryTestCase
{
    public function testSimpleMock()
    {
        $mock = \Mockery::mock(array('pi' => 3.1416, 'e' => 2.71));
        $this->assertEquals(3.1416, $mock->pi());
        $this->assertEquals(2.71, $mock->e());
    }
}
