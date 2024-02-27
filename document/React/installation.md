## 설치
- 이 프로젝트에서 사용하는 NodeJS는 20 버전이다. 다른 버전을 사용해도 되지만, 가급적 최신 버전을 사용하도록 하자.
```
nvm use 20
```

### 종속성 관리 도구
- pnpm을 설치하도록 하자.
```
npm install -g pnpm
```
- 설치되어 있는 npm으로 pnpm을 설치하도록 하자.
- 기존의 npm 환경을 완전히 분리할 수 있다면 pnpm을 사용하면 된다.

### vite 설치
```
pnpm create vite Frontend --template react-swc-ts
```
- 위의 명령어로 프로젝트를 설치한다. 그럼 프로젝트 최상단에 Frontend라는 폴더가 생성된다.
- 패키지 이름을 입력하라고 되어 있는데 디폴트 값으로 쓰자.
```
cd Frontend
pnpm install
pnpm run dev
```
- 위 명령어를 차례로 실행하라고 되어 있다. 실행 해 보자.
- `http://localhost:5173/`에서 리액트 프론트앤드가 실행되는 것을 확인할 수 있다.


## 어떤 방식으로 개발할 것인가?
### CSRF 문제
- 라라벨의 라우터 미들웨어 그룹은 기본적으로 web과 api가 존재한다. web 미들웨어 그룹의 경우에는 자사에서 사용되는 라우팅 리소스로 요청에 대한 보다 엄격한 검사를 하며, api 미들웨어 그룹의 경우에는 타사에서 이용할 수 있는 라우팅 리소스를 제공하는 것에 목적이 있기 때문에 덜 엄격한 검사를 진행한다. 자사 프론트앤드의 경우에는 web 미들웨어 그룹의 미들웨어를 사용하여 보다 엄격한 검사를 진행해야 한다.
- web 미들웨어 그룹에는 CSRF 검사라는 미들웨어가 포함이 된다. 이는 라라벨 서버에서 발행된 웹페이지인지를 확인하는 용도로 사용되며, 기본적으로 2시간의 인증 유효기간을 가진다. 웹 페이지가 변경될 때마다 CSRF 토큰을 새롭게 발급하면 계속 2시간이 연장되기 때문에 CSRF 인증이 끊기지 않고 유효한 리퀘스트를 서버에 전달할 수 있다.
- 웹 페이지를 장기간 사용하지 않았다면 CSRF 토큰이 인증되지 않아서 페이지를 리프레시 한 후 다시 발급을 받아야 한다.
- 만약 CSRF 인증을 하지 않는다면, 서버에 전달된 리퀘스트가 자사 백앤드에서 발급된 페이지인지 확인할 수 없기 때문에 다른 인증 수단이 없다면 서버는 의도치 않은 외부의 리퀘스트의 처리를 수행할 가능성이 생긴다.
- 기본적으로 라라벨은 CSRF 토큰을 Html의 meta 테그의 정보로 프론트앤드에 전달한다. SPA를 사용하는 웹은 대체로 페이지를 갱신하지 않고 API 요청을 수행한다. 페이지를 갱신하지 않는 상태가 지속되다가 2시간이 지나게 되면 CSRF 토큰이 만료되어 유저는 수동으로 페이지를 리프레시 해야 하는 상황을 맞이한다. 페이지를 새로 발급 받지 않아도 API 통신을 통해서 CSRF 토큰을 발급 받을 수 있도록 세팅을 해 주어야 한다.
- API로 CSRF 토큰을 리프레시 할 수 있는 기능을 제공하는 것은 sancturm을 사용하는 것과 inertia를 사용하는 방식이 존재한다.

### inertia
- 라라벨의 mix 또는 vite의 설정 위에서 페이지를 구축해야 한다.
- 만약 mix를 사용하고 있는데, vite를 사용해서 별도의 프론트앤드 페이지를 만들려고 한다면 설정을 할 수 없다는 문제가 있다.
- 기본적으로 vite를 설치하면 react 환경을 자동으로 구축해 준다. 하지만, inertial를 사용하면 react의 개발 환경이 보편적으로 사용되는 것 보다 제한되며 이를 위해 추가적인 환경을 설정해야 하는 경우가 생긴다.
- inertia의 가장 큰 장점은 RESTful API를 만들거나, GraphQL 환경을 구축하지 않고, 기존의 블레이드 페이지를 개발하듯이 만들면 되기 때문에 상당한 공수 절감을 이뤄낼 수 있다는 점이다. 하지만 페이지별로 데이터가 전달되다 보니, 한 번의 리퀘스트로 전달 받는 데이터의 양이 많아질 수 있는 문제점이 있으며, API를 재활용하지 못한다는 단점이 생겨날 수 있다.

## sanctum 설치하기
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
