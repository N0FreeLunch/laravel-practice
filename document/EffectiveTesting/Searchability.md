# 검색 가능성

테스트의 이름을 부여할 때, 원하는 테스트가 잘 검색될 수 있도록 이름을 부여하는 규칙을 생각하는 것은 중요하다.

## Prefix 부여하기

메인이 되는 큰 기능별 분류를 테스트 코드에 부여하는 방법을 사용할 수 있다.

```php
it('[API] 회원가입 요청 시 토큰을 반환한다', function() { ... });
it('[UI] 로그인 버튼 클릭 시 모달이 뜬다', function() { ... });
it('[Slow] 대용량 엑셀 다운로드 테스트', function() { ... });
```

#### 검색

```
pest --filter="[API]"
pest --filter="[Slow]"
```

## 해시 사용하기

메소드를 표기할 때 보통 #을 메소드명의 앞에 붙이는 방식을 사용한다.

유닛 테스트는 외부 의존성이 적은 코드를 테스트 할 때 사용하는데, 보통은 메소드의 동작을 테스트 하는데 많이 사용된다.

메소드를 `User#login`와 같이 해시 기호로 표시를 하기 때문에 메소드를 테스트 한다는 의미로 해시 기호 사용한 설명을 붙인다.


```js
describe('Calculator', function () {
    describe('#sum', function () { 
        it('두 수를 더한다', ...);
    });

    describe('#multiply', function () { 
        it('두 수를 곱한다', ...);
    });
});
```

#### 검색

```
pest --filter="#sum"
```

sum 메서드 관련 테스트만 골라낼 수 있다.

## When / With

context의 시작을 항상 특정 전치사나 접속사로 통일하는 방법이다.

When / With를 전치사로 하는 전치사 구를 포함하는 문장을 만들어 특정 조건이나 상황을 표현하는 테스트 명칭을 사용한다.

```php
context('when guest', function () { ... });
context('when admin', function () { ... });
context('with invalid data', function () { ... });
```

다른 언어권의 사용자 예를 들어 한국어의 경우에는 '~할 때' / '~한 경우'등의 통일된 표현을 사용하는 것을 통해 영문 When / With를 대체할 수 있다.

#### 검색

```
pest --filter="when guest"
pest --filter="with invalid"
```

```
pest --filter="게스트인 경우"
pest --filter="잘못된 때"
```

## 이슈 트래킹

특정 기능을 개발할 때, 관련된 티켓 번호나 트레킹을 할 수 있는 이슈 넘버를 함께 기록하는 방법이다.

```php
it('특수문자가 포함된 경우 에러를 뱉는다 (JIRA-402)', function () { ... });
it('결제 금액이 0원일 때 통과시킨다 (#521)', function () { ... });
```

#### 검색

```
pest --filter="402"
pest --filter="#521"
```
