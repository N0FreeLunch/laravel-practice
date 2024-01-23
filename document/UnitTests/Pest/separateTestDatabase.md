## 테스트 데이터베이스를 분리해야 하는 이유
- 테스트는 코드가 동작하는지를 테스트하기 위한 도구이다. 따라서 테스트가 일어나는 조건을 명확하게 해야 한다. 따라서 테스트하기 전의 데이터와 테스트 한 이후의 데이터가 어떻게 될지 명확하게 알아야 한다.
- 수 많은 테스트는 동시에 일어난다. 한 부분의 테스트로 인해서 다른 부분의 테스트가 이뤄질 때 사용되는 데이터의 변경이 일어날 수 있다.
- 따라서 테스트가 일어날 때는, 다른 테스트 코드의 동작으로 인해서 데이터의 변경 영향이 없도록 격리하는 것이 필요하다.
- 테스트 코드가 많아질수록 전체 코드를 테스트하는데 걸리는 시간이 늘어난다. 이 시간을 단축하기 위해서 병렬로 테스트를 돌리는데, 그러면 병렬로 돌아가는 테스트들이 모두 격리된 데이터로 테스트가 되어야 서로의 동작에 영향을 주지 않을 것이다.

### phpunit.xml 세팅하기
```xml
<php>
    <-- other code -->
    <server name="DB_CONNECTION" value="sqlite"/>
    <server name="DB_DATABASE" value=":memory:"/>
    <-- other code -->
</php>
```
- 테스트 프레임워크에서 사용할 데이터베이스를 지정한다. 여기서 프로젝트에서 사용하는 데이터베이스와 서로 다른 데이터베이스를 지정하는데, 보통 테스트를 위해서는 빠르게 동작할 수 있는 메모리 디비를 사용해서 테스트를 한다.

### tests/Pest.php 세팅하기
```php
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class)
    ->in('Unit', 'Feature');
```

### 테스트 코드 동작 후 데이터베이스 리프레시하기
```php
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)
    ->in('Unit', 'Feature');
```
- 위 세팅을 한 채로 `phpunit.xml`의 세팅으로 테스트데이터베이스를 별도로 지정하지 않으면 프로젝트에서 사용하고 있는 데이터베이스의 데이터가 사라지므로 주의해야 한다.
