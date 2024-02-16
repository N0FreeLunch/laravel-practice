## 메소드 인자 모의
- 메소드가 받는 인자값을 모의하자.

```php
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
```

#### 모의
- `shouldReceive('foo')` : `foo`라는 메소드는
- `->once()` : 한 번만 호출되며
- `->with($arg)` : 인자값으로 `$arg = 'bar'`을 받을 경우
- `->andReturn($returnValue)` : `$returnValue = 'foobar'`라는 값을 반환한다.

#### 모의 객체 사용
```php
$this->assertEquals($mock->foo($arg), $returnValue);
```
- 모의된 객체 `$mock`의 `foo`라는 메소드는 `'bar'`라는 인자를 받았을 때 `'foobar'`라는 결과값을 받는지 확인한다.

```php
// $this->assertEquals($mock->foo($arg), $returnValue);
```
- 동일한 코드를 주석 풀고 사용하게 될 경우, 모의할 때 설정한 `once()`에 의해 `foo`라는 메소드는 `'bar'`라는 인자를 받았을 때 `'foobar'`라는 결과값을 반환하는 것은 한 번 뿐이므로 2번을 호출 했을 때는 에러를 발생시킨다.
> Method foo('bar') from Mockery_0__MyClass should be called exactly 1 times but called 2 times.

## Reference
- https://docs.mockery.io/en/stable/getting_started/quick_reference.html
