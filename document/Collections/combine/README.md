## combine

> The combine method combines the values of the collection, as keys, with the values of another array or collection:
- 다른 배열이나 컬렉션의 값을 키로 하여 컬렉션의 값을 결합한다(combines).

### 예제

```php
$collection = collect(['name', 'age']);
 
$combined = $collection->combine(['George', 29]);
 
$combined->all();
 
// ['name' => 'George', 'age' => 29]
```
- 컬렉션에 나열된 원소들의 값을 키로, `combine`으로 추가된 배열에 나열된 값을 값으로 하는 배열을 생성한다.
- `['name', 'age']`를 키로 하고, `['George', 29]`을 값으로 하는 배열 `['name' => 'George', 'age' => 29]`가 반환 되었다. 동일 인덱스 매칭인 것을 알 수 있다.

### 실행 결과
```
array:2 [▼
  "name" => "George"
  "age" => 29
]
```

## References
- https://laravel.com/docs/11.x/collections#method-combine
- https://github.com/laravel/framework/blob/11.x/src/Illuminate/Collections/Collection.php#L891
- https://github.com/laravel/framework/blob/11.x/tests/Support/SupportCollectionTest.php#L4307
- https://github.com/laravel/framework/blob/11.x/tests/Support/SupportCollectionTest.php#L4348
