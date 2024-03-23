## SPA 인증용 sanctum 설치하기
- 라라벨의 sanctum은 spa 인증용 세션 쿠키를 이용한 API 라우터와 모바일 애플리케이션이나 서버의 토큰 인증과 같은 장기적으로 사용하기 위한 토큰을 발급하기 위한 용도의 토큰을 발급하는 용도로 사용될 수 있다.
- 여기서 sanctum을 다루는 방식은, SPA용 웹을 다루는 용도로 사용한다.

1. sanctum 인스톨
```
composer require laravel/sanctum
```

2. 구성 파일 세팅하기
```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

3. 마이그레이션 배제하기
- SPA 인증을 위해서는 마이그레이션을 할 필요는 없다. 반 영구적인 토큰을 발행하고 싶은 경우에는 마이그레이션을 실행한다.
- SPA 인증만 필요한 경우 `database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php`의 마이그레이션 파일을 지워준다.
- 토큰을 발급하여 인증하고 싶다면 위의 마이그레이션 파일로 톸큰을 저장하기 위한 테이블을 만들어 줘야 한다.
```
php artisan migrate
```

- 마이그레이션 파일을 지워도 마이그레이션에서 personal_access_tokens_table이 생성될 수 있다. 다음과 같이 `app/Providers/AppServiceProvider.php`에서 `Sanctum::ignoreMigrations()`를 실해할 수 있도록 하자.
```php
// ...
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {   
        // ...
        Sanctum::ignoreMigrations();
        // ...
    }

    // ...
}
```

4. SPA 인증을 위한 미들웨어 등록하기
- SPA 인증을 위한 설치를 한다면 `app/Http/Kernel.php`의 `api` 미들웨어에 다음 `EnsureFrontendRequestsAreStateful` 미들웨어를 추가한다.
```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

5. CORS 세팅
- `config/cors.php`에서 `supports_credentials`값을 true로 바꾸어 준다.
```
'supports_credentials' => true,
```

6. santurm에서 허용하기
- `config/sanctum.php`에서 `localhost:5173`를 허용해 준다.
- `.env` 파일에 `SANCTUM_STATEFUL_DOMAINS=localhost:5173`을 세팅해 주어도 된다.
