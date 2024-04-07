## all
> The all method returns the underlying array represented by the collection:
- all 메소드는 컬렉션이 나타내는 기본 배열을 반환합니다.

### 설명
- 컬렉션의 모든 순회 값을 배열으로 표현한다.
- 컬렉션의 값이 배열이 아니더라도 all 메소드의 결과값은 배열이 반환된다.

### 기본 예제코드
```php
collect([1, 2, 3])->all();
 
// [1, 2, 3]
```

### 추가 예제코드
```php
collect(collect([1, 2, 3]))->all();
 
// [1, 2, 3]
```

## Reference
- https://laravel.com/docs/11.x/collections#method-all
- https://laravel.com/api/11.x/Illuminate/Support/Collection.html#method_all
