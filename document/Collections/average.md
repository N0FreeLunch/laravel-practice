## average
> The avg method returns the average value of a given key:
- 주어진 키에 대응하는 값의 평균을 반환한다.

### 기본 예제코드
```php
$average = collect([
    ['foo' => 10],
    ['foo' => 10],
    ['foo' => 20],
    ['foo' => 40]
])->avg('foo');
 
// 20
 
$average = collect([1, 1, 2, 4])->avg();
 
// 2
```
- 컬렉션에는 `['foo' => 값]` 형식의 원소가 할당되어 있다.
- 컬렉션의 각 원소의 `'foo'` 키에 접근한 후 취득한 값들의 평균을 구한다.

### 추가 예제코드
```php
$average = collect([
    ['foo' => 10],
    ['foo' => 10],
    ['foo' => 20],
    ['bar' => 40]
])->avg('foo');

// 13.333333333333334
```
- 지정한 키가 없는 원소(`['bar' => 40]`)가 있다면 평균을 구하는 대상에서 제외한다.
`['foo' => 10], ['foo' => 10], ['foo' => 20]`에 대해서만 평균을 구하므로 10+10+20/3으로 계산이 되며, `['bar' => 40]`는 키가 존재하지 않으므로 평균값 계산 대상에서 제외한다.

## Reference
- https://laravel.com/docs/11.x/collections#method-average
- https://laravel.com/api/11.x/Illuminate/Support/Collection.html#method_average
