## Describe/Group Block

`describe` 함수를 사용하여 정의한다.

테스트 대상(클래스, 기능)을 정의하고 관련 테스트들을 묶어주는 역할.

```php
describe('sum', function () {
   it('may sum integers', function () {
       $result = sum(1, 2);
 
       expect($result)->toBe(3);
    });
 
    it('may sum floats', function () {
       $result = sum(1.5, 2.5);
 
       expect($result)->toBe(4.0);
    });
});
```

## Test Closure

`it` 함수를 사용하여 정의한다.

단일 시나리오를 작성할 때 사용한다. 무엇을 테스트 할지를 명확하게 문장으로 서술하고, 해당 문장의 의미에 맞는 테스트를 작성한다.

```php
it('performs sums', function () {
   $result = sum(1, 2);
 
   expect($result)->toBe(3);
});
```

## Expectation

변수 또는 반환 값이 원하는 결과값에 해당하는지 확인하는 최소 단위로 `expect` 메소드를 사용하여 정의한다.

it을 기반으로 Test Closure의 테스트에서 모든 expect가 성공이면 Test Closure는 성공한 것이고 어느 하나의 expect라도 실패하면 Test Closure는 실패한 것이 된다.

```php
expect($value)
    ->toBeInt()
    ->toBe(3)
    ->not->toBeString()
    ->not->toBe(4);
```
