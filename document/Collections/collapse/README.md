## collapse

> The collapse method collapses a collection of arrays into a single, flat collection:
- 배열들의 컬렉션을 (배열을 컬렉션으로 하는) 하나의 배열로 붕괴시키는 flat 컬렉션이다.

### 예제
```php
$collection = collect([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
]);

$collapsed = $collection->collapse();

$collapsed->all();
```
- 배열 원소의 컬렉션의 각각의 배열의 원소를 컬렉션의 원소로 변환한다.
- 주의: 재귀적으로 배열의 중첩을 해제하지는 않는다.

### 실행 결과

```
array:9 [▼
  0 => 1
  1 => 2
  2 => 3
  3 => 4
  4 => 5
  5 => 6
  6 => 7
  7 => 8
  8 => 9
]
```

## References
- https://laravel.com/docs/11.x/collections#method-collapse
- https://github.com/laravel/framework/blob/11.x/src/Illuminate/Collections/Collection.php#L139
- https://github.com/laravel/framework/blob/11.x/tests/Support/SupportCollectionTest.php#L1712
