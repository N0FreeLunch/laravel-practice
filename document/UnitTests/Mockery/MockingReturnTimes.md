## 회차별 리턴값 변경 모킹
```php
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
```
- `shouldReceive('foo')` : `foo` 라는 메소드를 만약 사용한다면 
- `andReturn(1, 2, 3)` : 첫 번째 호출에서 1을 반환, 두 번째 호출에서 2를 반환, 세 번째 호출에서 3을 반환한다. 지정하지 않은 횟수의 호출에서는 마지막에 반환된 값을 계속 반환한다.
- 호출 횟수를 정하고 싶은 경우에는 `once()` `times(3)`와 같은 함수를 추가해서 모킹을 해 줘야 하며, 이들 메소드를 추가하지 않았다면, 계속 호출할 수 있고 마지막에 반환된 값이 반환된다.
- `$this->assertEquals($mock->foo(), 1)` 부분을 보면 3번째 호출 부터는 모두 동일하게 3을 반환하는 것을 확인할 수 있다.
