## average, avg
> The avg method returns the average value of a given key:
- 주어진 키에 대응하는 값의 평균을 반환한다.

### 문법
```
@param  (callable(TValue): float|int)|string|null  $callback
@return float|int|null
```
- `float|int|null` 반환값은 수에 해당하는 값 또는 null이다. null이 반환되는 경우는 평균값을 계산할 수 없는 경우이다.
- `(callable(TValue): float|int)|string|null` 콜백함수는 임의의 타입을 지정할 수 있으며, 콜백 함수의 반환값은 수(int형, float형)을 반환한다. 문자열을 할당할 때는 컬렉션 원소의 키가 가진 값에 접근한다.

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
#### 원소에 지정된 키가 없는 경우
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
`['foo' => 10], ['foo' => 10], ['foo' => 20]`에 대해서만 평균을 구하므로 (10+10+20)/3으로 계산이 되며, `['bar' => 40]`는 키가 존재하지 않으므로 평균값 계산 대상에서 제외한다.

#### 인자로 콜백 함수를 할당한 경우
```php
$average = collect([
    ['foo' => 10],
    ['foo' => 10],
    ['foo' => 20],
    ['bar' => 40]
])->avg(function($value) { return $value['foo']*10; });
```
- 콜백함수의 반환 값이 `null`이 아닌 경우에는 반환 값을 수로 변경하여 평균을 계산한다. `['bar' => 40]`의 경우 위 콜백함수에서 반환 값이 형변환에 의해 0이 되고 (10+10+20+0)/4의 결과 값을 갖는다.

```php
$average = collect([
    ['foo' => 10],
    ['foo' => 10],
    ['foo' => 20],
    ['bar' => 40]
])->avg(function($value) { 
    if(array_key_exists('foo', $value)) {
    	return $value['foo']*10; 
    } else {
        return null;
    }
});
```
- 위와 같이 null을 반환하면 해당 원소를 계산에 포함하지 않는다.

#### 결과값이 null인 경우
```php
$average = collect([
    ['foo' => 10],
    ['foo' => 10],
    ['foo' => 20],
    ['foo' => 40]
])->avg('bar');
```
- 평균값을 계산할 수 있는 대상 원소가 없기 때문에 처리되지 않았다는 의미에서 null이 반환 되었다.

## Reference
- https://laravel.com/docs/11.x/collections#method-average
- https://laravel.com/api/11.x/Illuminate/Support/Collection.html#method_avg
- https://github.com/laravel/framework/blob/11.x/src/Illuminate/Collections/Collection.php
