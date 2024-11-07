## chunk
> The chunk method breaks the collection into multiple, smaller collections of a given size:
- 주어진 사이즈 보다 작은 컬렉션들로 컬렉션을 여럿으로 쪼갠다.

### 예제

```php
$collection = collect([1, 2, 3, 4, 5, 6, 7]);

$chunks = $collection->chunk(4);

$chunks->all();
 
// [[1, 2, 3, 4], [5, 6, 7]]
```
- 배열의 원소를 지정한 길이 만큼으로 조각낸다. 각각의 조각은 컬렉션 객체이며 이들 조각을 원소로 한 배열을 반환한다.

### 실행 결과
```
array:2 [▼
  0 => Illuminate\Support\Collection { ▼
    #items: array:4 [▼
      0 => 1
      1 => 2
      2 => 3
      3 => 4
    ]
  }
  1 => Illuminate\Support\Collection { ▼
    #items: array:3 [▼
      4 => 5
      5 => 6
      6 => 7
    ]
  }
]
```

## References
- https://laravel.com/docs/11.x/collections#method-chunk
- https://github.com/laravel/framework/blob/11.x/src/Illuminate/Collections/Collection.php#L1433
- https://github.com/laravel/framework/blob/11.x/tests/Support/SupportCollectionTest.php#L2071
