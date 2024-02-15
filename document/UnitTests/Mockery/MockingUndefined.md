## 에러 대체하여 중단 없는 테스트하기
- Mockery를 이용해서 정의되지 않은 값을 모의할 때는 실제 정의되지 않은 값을 php에서 함수나 메소드의 반환값으로 반환할 수 없기 때문에 `Mockery\Undefined`를 사용한다.
- php에서 정의되지 않은 값을 사용하는 것이 에러나 경고를 발생 시키기 때문에 php의 중단되는 문법의 실행을 피하면서 실행의 결과만을 테스트하고자 할 때 사용한다.
- 아래 예제에서는 0으로 나누는 경우를 모의하고 있다. 0으로 나누는 것은 php에서 허가되지 않기 때문에 테스트 코드를 중단하지 않고 실행하여 테스트를 하기 위해서는 0으로 나누는 것에 해당하는 타입을 지정하는 케이스를 설정하여 테스트를 한다.
- 이 때, 0으로 나누는 결과에 해당하는 커스텀 타입은 `Mockery\Undefined`에 해당한다.

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
- php에서는 0으로 나눌 경우 에러가 발생한다. 또한 메서드의 반환 값은 0이 될 수 없다. 위의 예제는 테스트를 위해서 에러를 발생 시키는 것을 대체하여 0으로 나눴을 때의 코드가 실행되는 가상의 메소드를 만드는 것으로 실제 php에서 불가능한 대상도 만들어 낼 수 있다는 예제이다.

## Reference
- https://docs.mockery.io/en/stable/getting_started/quick_reference.html
