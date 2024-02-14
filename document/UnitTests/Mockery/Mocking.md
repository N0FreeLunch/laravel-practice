## Mocking
```php
use \PHPUnit\Framework\TestCase;

class Temperature
{
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function average()
    {
        $total = 0;
        for ($i=0; $i<3; $i++) {
            $total += $this->service->readTemp();
        }
        return $total/3;
    }
}

class TemperatureTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetsAverageTemperatureFromThreeServiceReadings()
    {
        $service = Mockery::mock('service');
        $service->shouldReceive('readTemp')
            ->times(3)
            ->andReturn(10, 12, 14);

        $temperature = new Temperature($service);

        $this->assertEquals(12, $temperature->average());
    }
}

```

### 네임 스페이스
- 테스트 코드에서 Mockery는 기본적으로 사용 가능하다. `use Mockery`를 사용하지 않도록 한다. 사용하면 다음 메시지가 나온다.
> The use statement with non-compound name 'Mockery' has no effect

### Temperature 클래스
- 모의를 할 대상 클래스이다. 이 클래스는 `service`라는 객체를 받아서 객체가 가진 온도 메소드를 사용한다. 이 때 `readTemp`는 여러번 읽으면 읽을 수록 값이 달라지는 속성을 갖고 있다.

### 테스트 코드

#### 모의
- `service`란 클래스는 위의 코드에서 존재하지 않는다. 존재하지 않는 클래스이지만 다음과 `Mockery`로 가상의 객체를 만들 수 있다.
```php
Mockery::mock('service')
```

```php
$service = Mockery::mock('service');
```
- `$service`라는 변수에 대입을 했는데, 마치 클래스 처럼 행동하는 가상의 클래스를 `$service`라는 변수에 할당하였다.
```php
$service->shouldReceive('readTemp')
        ->times(3)
        ->andReturn(10, 12, 14);
```
- 객체의 행동을 모의하였다.
- `shouldReceive`는 '~을 받아야 한다'라는 의미를 갖고 있다. 모의한 객체는 `readTemp`라는 메소드 사용하는 코드를 받아야 한다는 의미로, 지정한 메소드를 사용했을 때의 실행 양상을 설정하겠다는 의미를 가지고 있다.
- `->times(3)`는 `shouldReceive`로 지정한 메소드를 실행했을 때 3번까지 모의한 값을 실행하겠다는 의미를 갖고 있다.
- `->andReturn(10, 12, 14)` `readTemp` 메소드를 실행 했을 때 모의한 값으로 10, 12, 14를 차례로 반환한다는 의미를 가진다.

```php
$temperature = new Temperature($service);
$this->assertEquals(12, $temperature->average());
```
- `$service`라는 객체를 주입했을 때 `Temperature` 객체는 내부에서 `$service` 객체의 `readTemp` 메소드를 3번 호출하고 그 평균을 구하도록 한다. 그래서 10, 12, 14의 평균이 12 이므로 `$temperature->average()`의 값은 12가 된다.

## Reference
- https://docs.mockery.io/en/stable/getting_started/simple_example.html
