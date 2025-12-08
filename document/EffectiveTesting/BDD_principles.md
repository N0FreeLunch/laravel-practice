# BDD의 철학

## 행위에 집중하기

비즈니스 관계자들이 알 수 있는 문장으로 테스트를 작성한다.

## it 블록을 문장처럼 작성하기

```php
it('사용자가 유효한 이메일을 제공하면 저장되어야 한다', function () { ... });
```

## 테스트의 기본 구조

모든 테스트는 '준비 - 실행 - 검증'의 3단계로 이뤄진다.

- 준비 (Arrange/Given)
- 실행 (Act/When)
- 검증 (Assert/Then)

```php
it('사용자가 유효한 이메일을 제공하면 저장되어야 한다', function () {
    $user = User::factory()->make([
        'email' => 'valid.email@example.com',
        'password' => 'password',
    ]);

    $isSaved = $user->save();

    expect($isSaved)->toBeTrue();

    $this->assertDatabaseHas('users', ['email' => 'valid.email@example.com']);
});
```
- `$user = User::factory()->make([ ... ])`: [Given/Arrange] 준비: Model Factory를 사용하여 테스트에 필요한 객체 생성
- `$isSaved = $user->save();`: [When/Act] 실행: 실제로 테스트하려는 행위 수행
- `expect($isSaved)->toBeTrue();`: 저장에 성공했는지 검증
- `$this->assertDatabaseHas('users', ['email' => 'valid.email@example.com']) `: // DB에 실제로 저장되었는지 검증

## 참고: model factory 사용법

#### 단순 생성

```php
$user = User::factory()->create();
```
DB에 저장하면서 생성

#### 특정 필드 오버라이드

```php
$admin = User::factory()->create(['is_admin' => true]);
```

#### DB에 저장하지 않고 객체만 생성 (단위 테스트에서 유용)

```php
$guest = User::factory()->make();
```
