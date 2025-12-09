# 피쳐 테스트

프레임워크의 부트스트레핑 과정을 로딩하여 테스트를 진행할 때, 프레임워크의 각종 전역 변수 및 데이터베이스 세팅 및 레디스 세팅 등을 활용할 수 있도록 한다.

## 브라우저 행동 시뮬레이션

사용자가 특정 페이지에 접속하거나, 폼을 제출하는 등의 사용자 행위를, 기획자 또는 티켓의 의뢰자가 원하는 동작을 코드로 시뮬레이션한다.

`actingAs()`, `get()`, `post()`, `assertSee()`, `assertRedirect()`

```php
it('유저가 새 게시물을 작성', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/posts/create')
        ->assertStatus(200)
        ->post('/posts', [
            'title' => 'The first content',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ])
        ->assertRedirect('/posts');

    $this->assertDatabaseHas('posts', [
        'title' => 'The first content',
        'user_id' => $user->id,
    ]);
});
```

- `$this->actingAs($user)`:  Given/Arrange: 인증된 사용자로 테스트
- `get('/posts/create')`: When/Act: 게시물 생성 페이지에 접근하여
- `assertStatus(200)`: 성공적으로 페이지가 로드되었는지 확인
- `->post('/posts', ...)`: When/Act: 유효한 데이터로 폼을 제출
- `assertRedirect('/posts')`: 성공 후 리다이렉트가 이루어졌는지 확인
- `$this->assertDatabaseHas('posts', ...)`: Then/Assert: 데이터베이스에 실제로 저장되었는지 확인
