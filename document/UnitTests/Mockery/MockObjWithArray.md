## 배열로 모의 객체 만들기
```php
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


```
- `\Mockery::mock`에 배열 `array('pi' => 3.1416, 'e' => 2.71)`을 할당하여 만들어진 값은 배열의 키를 메서드로 하여 `->pi()`, `->e()`로 호출할 수 있는 객체를 만들어 낸다.

## Reference
- https://docs.mockery.io/en/stable/getting_started/quick_reference.html
