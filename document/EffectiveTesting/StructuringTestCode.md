# 테스트 코드 구조화

## 테스트 코드도 메인테넌스 대상이다

### 비즈니스 의도 반영하기

테스트 할 대상 리스트는 비즈니스에서 성립되어야 할 충족 요건을 만족해야 한다.

테스트 목록은 비즈니스에서 요구하는 조건들을 만족해야 하며, 시스템을 통해 동작시키려는 움직임의 흐름을 제공해야 한다.

### 구조화 하기

#### Grouping

describe()와 context()를 사용하여 테스트 항목들을 그룹화 할 수 있다.

describe()와 context()는 기능상으로는 동일하지만, describe는 현재 무엇을 테스트할지 테스트의 주제, 목적, 대상 등을 설명할 때 사용하며, context는 특정한 조건 맥락 안에서 조건이나 상황을 설명하는 의미적인 차이가 있다.

최종적인 기대 동작의 기술 및 검증은 it을 통해서 이뤄지므로 describe으로 전체의 개요를 설명하고, context으로 특정 조건에서 이뤄지는 대상을 그룹화 하며, it으로 기대 동작을 기술한다.

```php
describe('The Subject (Noun)', function () {
    context('When / With (Condition)', function () {
        it('should do something (Verb)', function () {
            // ...
        });
    });
});
```

```php
describe('Calculator', function () {       
    context('when adding positive numbers', function () { 
        it('returns the sum', function () { 
            // ...
        });
    });
});
```

#### Setup

테스트 항목의 로직을 성립하는데 있어서 공통적으로 사용할 수 있는 부분이 있다면 공통적으로 동일하게 적용할 수 있는 선행 조건을 세팅할 필요가 있다.

beforeEach를 사용하면 각 테스트 항목이 동작하기 전에 필요한 선행 조건(미리 로딩해야 하는 코드나 데이터)을 세팅 할 수 있다.

중요한 것은, beforeEach로 각각의 그룹핑 단위에서 공통의 선행 조건을 세팅할 수 있다는 것이다.

다음의 예시는 관리자 데이터 생성인데, 테스트를 하기에 앞서 동일한 데이터를 생성해야 한다. 각각의 테스트 항목 (it 함수 각각)에 각각 이 조건을 세팅하는 것 보다는, 테스트가 돌아갈 때 공통적인 부분이므로 공통적인 코드를 작성하도록 한다.

```php
describe('관리자 대시보드', function () {
    it('접속 성공', function () {
        $admin = User::factory()->create(['is_admin' => true]); 
        
        $this->actingAs($admin)->get('/admin')->assertOk();
    });

    it('통계 데이터 확인', function () {
        $admin = User::factory()->create(['is_admin' => true]);
        
        $this->actingAs($admin)->get('/admin/stats')->assertOk();
    });
});
```

```php
describe('관리자 대시보드', function () {
    beforeEach(function () {
        $this->admin = User::factory()->create(['is_admin' => true]);
    });

    it('접속 성공', function () {
        $this->actingAs($this->admin)->get('/admin')->assertOk();
    });

    it('통계 데이터 확인', function () {
        $this->actingAs($this->admin)->get('/admin/stats')->assertOk();
    });
});
```

describe 블록 뿐 아니라 중첩된 구조에서도 다음과 같이 사용할 수 있다.

```php
describe('쇼핑몰', function () {
    beforeEach(function () {
        $this->shop = Shop::create();
    });

    context('로그인한 사용자', function () {
        beforeEach(function () {
            $this->user = User::factory()->create();
            $this->actingAs($this->user);
        });

        context('장바구니에 상품이 있을 때', function () {
            beforeEach(function () {
                $this->product = Product::factory()->create();
                $this->cart->add($this->product);
            });

            it('결제 화면으로 이동한다', function () {
                get('/checkout')->assertOk();
            });
        });
    });
});
```

#### dataset

하나의 테스트 로직으로 데이터를 기반으로 한 여러 테스트 케이스를 검증하는 방법을 사용한다.
