# 공통 로직 뽑아내기

테스트를 작성할 때 여러 테스트에서 공통적으로 수행해야 하는 로직을 따로 분리할 수 있다.

## 별도의 파일에 공통 로직을 사용할 때

### 트레이트 사용하기

pest에서는 테스트 그룹이나 항목의 익명 함수 내에서 `uses`라는 함수로 트레이트를 부르면, 해당 테스트에서 트레이트의 메소드가 실행된다.

문제는 트레이트 자체는 트레이트 설명을 갖고 있지 않기 때문에 describe, context 블록이나 it 블록을 함께 사용하여 결과 창에 설명이 표시되도록 해 주어야 한다.

```php
trait LockableTests {
    public function test_fails_login_5_times_locks_account() {
        
        $model = $this->model; 

        foreach(range(1, 5) as $i) {
            $model->recordLoginFailure();
        }

        expect($model->isLocked())->toBeTrue();
    }
}
```

```php
describe('User Model', function () {
    uses(LockableTests::class); 

    beforeEach(function () {
        $this->model = User::factory()->create();
    });
});

describe('Admin Model', function () {
    uses(LockableTests::class); 

    beforeEach(function () {
        $this->model = Admin::factory()->create();
    });
});
```

### 정적 메소드 사용하기

기명 함수에 테스트 그룹이나 항목을 적은 후, 테스트 그룹이나 항목에서 정의된 기명함수를 불러 테스트를 실행하는 방법을 사용할 수 있으나, 기명함수는 함수명이 전역 범위로 공유되기 때문에, 겹치지 않게 하기 위한 특별한 네이밍 룰이 있어야 한다.

일반적으로 php에서는 기명함수를 사용하기 보다는, 네임 스페이스를 사용할 수 있는 클래스를 사용해서 테스트 그룹이나 항목을 정적 메소드에 정의하여 정적 메소드를 호출하는 방식으로 공통으로 실행되어야 할 테스트 코드를 정의하는 방식을 사용한다.

기명 함수에도 네임 스페이스를 사용할 수 있지만 기명 함수는 네임스페이스를 등록하는 절차가 추가되기 때문에 일반적으로는 클래스를 사용한 네임스페이스를 사용한다.

```php
namespace Tests\Shared;

class AuthenticationBehaviors
{
    public static function assertLockable()
    {
        it('5회 실패 시 계정 잠금', function () {
            $model = $this->model;
            // ...
        });

        it('잠김 상태에서는 로그인이 불가능한가?', function () {
            // ...
        });
    }

    public static function assertPasswordReset()
    {
        it('비밀번호 재설정 링크를 메일로 전송', function () {
            // ...
        });
    }
}
```

```php
use Tests\Shared\AuthenticationBehaviors;

describe('User Model', function () {
    beforeEach(function () {
        $this->model = User::factory()->create();
    });

    AuthenticationBehaviors::assertLockable();    
});
```


## 하나의 파일만 공통 로직을 사용할 때

### 기명 함수 사용하기

하나의 테스트 파일에서만 공통적으로 쓰이는 테스트의 경우, 기명 함수를 정의하여 각 테스트 그룹이나 항목에서 함수의 `use` 키워드로 정의된 기명함수를 불러오는 방식을 사용할 수 있다.

단, 이는 `use` 키워드를 반복적으로 사용해야 한다는 가독성 때문에 추천되는 방식은 아니다. 테스트를 구조화 할 때, 상위 그룹에서 부터 하위 그룹까지 차례로 전달해야 하기 때문에, 특정 하위 블록까지 익명 함수를 변수로 전달할 때, 반복적으로 모든 함수 스코프에 `use` 키워드를 사용해야 해서 너무 지저분해진다는 문제점이 있다.

```php
describe('상위 그룹', function () {
    $helper = function () { ... };

    context('중간 그룹', function () use ($helper) {
        
        context('하위 그룹', function () use ($helper) {
            
            it('테스트 수행', function () use ($helper) {
                $helper();
            });
        });
    });
});
```

### 네임스페이스 사용하기

네임스페이스를 사용하면, 기명함수의 범위가 네임스페이스 범위로 한정되는 것을 이용해서, 기명함수를 사용하되, 전역 공간의 함수의 이름이 중복되지 않도록 파일에 네임스페이스를 부여하도록 한다.

```php
namespace Tests\Feature\OrderTestSpace;

use App\Models\Order;

function assertStatus(Order $order, string $status) {
    expect($order->status)->toBe($status);
}

describe('주문 테스트', function () {
    it('배송 중 상태 확인', function () {
        $order = Order::factory()->create(['status' => 'shipping']);
        
        assertStatus($order, 'shipping'); 
    });
});
``` 

### 확장함수 등록하기

pest의 `expect` 함수가 반환하는 `Expectation`의 메소드 체인에 `extend`로 동적으로 메소드를 추가할 수 있다.

테스트 로직 단위의 공유는 아니고 검증의 툴을 통해서 테스트 그룹이나 항목의 로직을 간결하게 돕는 정도의 역할을 한다.

```php
expect()->extend('toBeStatus', function (string $status) {
    return $this->status->toBe($status);
});

describe('주문 테스트', function () {
    it('배송 중 상태 확인', function () {
        $order = Order::factory()->create(['status' => 'shipping']);

        expect($order)->toBeStatus('shipping');
    });

    it('배송 완료 상태 확인', function () {
        $order = Order::factory()->create(['status' => 'delivered']);
        
        expect($order)->toBeStatus('delivered');
    });
});
```

위의 방식은 동적으로 메소드를 등록하는 방식이므로 정적 분석이 되지 않기 때문에 타입힌팅을 위해 다음과 같은 트릭이 필요하다.

```php
/**
 * @method self toBeStatus(string $status)
 */
class Expectation extends \Pest\Expectation
{
    // Don't define real code here.
}

expect()->extend('toBeStatus', function ($status) {
    return $this->value->status->toBe($status);
});
```


