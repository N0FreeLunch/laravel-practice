## php에서 불가능한 모의 객체 만들기

```php
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
```
- `\Mockery::mock('mymock')` : `mymock`이란 가상 클래스를 만든다.
- `shouldReceive('divideBy')` : 모의한 클래스는 `divideBy`라는 메소드를 사용하는 경우로 한정한다.
- `with(0)` :  `divideBy`라는 메소드를 사용했을 때 0이란 값을 받을 경우로 한정한다.
- `andReturnUndefined()` : 정의되지 않은 값을 반환한다는 의미이다.
- php에서는 0으로 나눌 경우 에러가 발생한다. 또한 메서드의 반환 값은 0이 될 수 없다. 위의 예제는 가상의 메소드를 만드는 것으로 실제 php에서 불가능한 대상도 만들어 낼 수 있다는 예제이다.

## Reference
- https://docs.mockery.io/en/stable/getting_started/quick_reference.html
