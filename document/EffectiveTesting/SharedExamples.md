# 공통 로직 뽑아내기

테스트를 작성할 때 여러 테스트에서 공통적으로 수행해야 하는 로직을 따로 분리할 수 있다.

## 트레이트 사용하기

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
