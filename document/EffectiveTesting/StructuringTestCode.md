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

beforeEach()를 사용하여 테스트 검증할 테스트 대상의 선행 조건을 미리 설정 실행할 수 있다.

#### dataset

하나의 테스트 로직으로 데이터를 기반으로 한 여러 테스트 케이스를 검증하는 방법을 사용한다.
