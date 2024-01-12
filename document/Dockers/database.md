## 데이터베이스 설치하기

### docker compose example
- 도커로 데이터 베이스를 설치하는 방법은 도커 공식 페이지의 컨테이너별로 설명이 나온다.
- MySql의 설치 방법은 도커 공식 페이지에서 제공한 [예시](https://hub.docker.com/_/mysql)를 참고한다.
```yml
version: '3.1'

services:

  db:
    image: mysql
    # NOTE: use of "mysql_native_password" is not recommended: https://dev.mysql.com/doc/refman/8.0/en/upgrading-from-previous-series.html#upgrade-caching-sha2-password
    # (this is just an example, not intended to be a production configuration)
    command: --default-authentication-plugin=mysql_native_password
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: example

  adminer:
    image: adminer
    restart: always
    ports:
      - 8080:8080
```

### 인증 관련 옵션
- 데이터베이스는 비밀번호 암호화에 필요한 함수를 제공한다. 이 때 사용하는 암호화 방식에 관한 알고리즘이 MySql8 버전부터는 업그레이드 된 모양이다.
- 'mysql_native_password'는 MySql8 이전 버전에서 사용하는 방식이며 이후 버전 부터는 'caching_sha2_password' 또는 'sha256_password'를 사용하기를 추천한다. 만약 'mysql_native_password'에서 'caching_sha2_password' 또는 'sha256_password'으로 바꾼 후 문제가 발생한다면 이전 방식으로 되돌리라는 설명이 되어 있다.
- 'caching_sha2_password'는 'sha256_password' 보다 더 나은 성능을 제공한다고 했으므로 'caching_sha2_password'를 사용하도록 하자.

### 비밀번호 옵션
- 기본적으로 비밀번호는 env 파일의 것을 사용한다. 연습용 리포지토리는 로컬환경에서만 사용할 것이므로 특별히 문제가 되지 않지만 프로패셔널한 모습을 위해 항상 비밀번호는 공유되지 않는 방식을 사용한다.
- docker-compose에서 env 파일의 데이터를 가져오는 방법은 [다음](https://docs.docker.com/compose/environment-variables/set-environment-variables/#additional-information)을 참고하도록 하자.

### 포트 옵션
- 포트는 시스템의 다른 포트 또는 다른 도커의 포트와 충돌하지 않도록 잘 사용되지 않는 번호를 사용하도록 한다.

### adminer
- adminer는 웹 화면으로 데이터베이스를 관리할 수 있는 툴이다. 연습용 툴으로 자주 사용되며, 별도의 디비를 다루는 툴을 사용하고 있다면 굳이 설치하지 않아도 된다.

### 변경된 docker compose
```yml
version: '3.9'

services:

  db:
    image: mysql
    command: --default-authentication-plugin=caching_sha2_password
    restart: always
    ports:
      - ${DB_PORT}:3306
    environment:
      MYSQL_ROOT_PASSWORD: $DB_PASSWORD
```

- `ports:` 하위의 yaml 시퀀스로 표기하며, 시퀀스 내의 값은 yaml 맵이 아니라 yaml 스칼라 값이다. `${DB_PORT}:3306`는 하나의 스칼라 값이며 하나의 문자열이다. 하나의 문자열 내에서 환경 변수 `DB_PORT`를 구분해 쓰기 위해서 `$DB_PORT:3306`가 아닌 `${DB_PORT}:3306`를 사용한다. `:`를 기준으로 왼쪽인 `${DB_PORT}` 부분은 외부에서 도커로 접속할 때의 포트를 지정하며 `:` 기준으로 오른쪽인 `3306`은 컨테이너 내부에서 MySql이 서빙되는 포트를 의미한다.
- `environment:` 하위에는 yaml 스칼라로 표기하며, 환경변수의 키를 나열한다. 만약 `.env` 파일의 환경 변수와 일치하는 대상이 있으면 해당 환경 변수를 가져오고, 일치하는 항목이 없을 때는 스칼라가 아닌 맵 형식으로 지정해 줘야 한다. 위 코드는 도커 컨테이너의 `MYSQL_ROOT_PASSWORD` 환경 변수에 해당하는 값에 `.env` 파일의 `DB_PASSWORD` 환경 변수를 사용하는 코드이다.

### 접속
- MySql의 디폴트 데이터베이스명은 `mysql`이다. 따라서 `.env` 파일의 `DB_DATABASE=` 부분을 `mysql`로 설정한다.
- 라라벨에서 데이터 베이스 접속을 확인하기 위해서는 `php artisan tinker` 명령으로 커멘드라인에서 프로그래밍 언어를 실행할 수 있는 프로그램을 실행한다. 그 후 `\DB::connection()->getPdo();`를 입력해서 PDO 객체를 에러 없이 가져오는지 확인하는 것으로 데이터베이스 커넥션을 확인할 수 있다.

### 여러가지 옵션
- MySql 도커의 [공식문서](https://hub.docker.com/_/mysql)를 보면, 'Environment Variables'라는 항목이 있다.

#### MYSQL_DATABASE
- 생성되는 데이터베이스의 이름을 지정할 수 있다. 이 값을 지정하지 않으면 데이터베이스 이름은 `mysql`이 된다.
```yml
environment:
    MYSQL_DATABASE: $DB_DATABASE
```

#### MYSQL_USER, MYSQL_PASSWORD
```yml
environment:
    MYSQL_USER: $DB_USERNAME
    MYSQL_PASSWORD: $DB_PASSWORD
```
- 기본적으로 데이터베이스가 생성될 때, root라는 데이터베이스 계정이 생기고 root 계정으로 데이터베이스 콘솔에 접근 할 수 있다.
- 하지만, root는 데이터베이스을 다루는데에 있어 모든 권한을 갖고 있기 때문에 새로운 유저를 만들어서 권한을 제한하여 데이터베이스를 치명적인 조작으로부터 보호하는 것이 필요하다. 물론 `MYSQL_USER`으로 새로운 유저를 생성하더라도, 기본적으로는 최대 권한을 갖고 있기 때문에 별도의 유저 기능 제한을 추가해 줘야 한다.
- 제한된 계정으로는 데이터베이스 관련 설정 중에 잘못된 설정으로 인해 원 상태로 돌아갈 수 없는 경우가 생길 수 있다. 이런 경우를 대비하여 모든 권한을 가진 root 계정을 두고 권한이 제한되는 새로운 계정을 하나 만들어 사용한다.

#### MYSQL_ALLOW_EMPTY_PASSWORD
- root 사용자의 비밀번호를 설정하지 않을 때 사용한다.
- 연습용이 아닌 실사용이라면 절대 사용하면 안 되는 옵션이다.
```yml
environment:
    MYSQL_ALLOW_EMPTY_PASSWORD: 
```
- 위와 같이 빈 값이면 빈 비밀번호가 생성되지 않는다.
```yml
environment:
    MYSQL_ALLOW_EMPTY_PASSWORD: qwer
```
- 하지만 위와 같이 어떤 값이든 있다면 비밀번호 없이 데이터베이스에 로그인 할 수 있따. 보통 `yes`를 적어준다.

#### MYSQL_RANDOM_ROOT_PASSWORD
- 데이터베이스 생성시 root 유저의 초기 비밀번호를 자동생성하기 위해서 사용한다.
- 자동생성된 비밀번호는 도커 로그를 통해서 확인할 수 있다.
```yml
environment:
    MYSQL_RANDOM_ROOT_PASSWORD:
```
- 위와 같이 비어 있다면 비밀번호가 발급되지 않는다.
```yml
environment:
    MYSQL_RANDOM_ROOT_PASSWORD: asdf
```
- 하지만 위와 같이 어떤 값이든 있다면 자동으로 비밀번호가 발급된다. 보통 `yes`를 적어준다.

#### MYSQL_ONETIME_PASSWORD
- 첫번째 로그인과 동시에 비밀번호를 변경하라는 요구가 나오도록 한다.
```yml
environment:
    MYSQL_ONETIME_PASSWORD:
```
- 위와 같이 비어 있다면 데이터베이스에 처음 로그인을 하더라도 비밀번호를 바꾸라는 요구사항이 나오지 않는다.
```yml
environment:
    MYSQL_ONETIME_PASSWORD: 1q2w
```
- 하지만 위와 같이 어떤 값이든 있다면 처음 로그인을 할 때 비밀번호를 바꾸라는 요구사항이 나온다. 비밀번호를 바꿀 때 까지 계속 요구사항을 표시한다. 보통 `yes`를 적어준다.

#### MYSQL_INITDB_SKIP_TZINFO
- 처음 MySql이 설치될 때 자동으로 타임존이 세팅되며, OS의 타임존을 기준으로 설정된다. 도커의 경우 도커가 동작하는 리눅스에 기본 세팅된 타임존을 기준으로 시간이 저장된다.
- 이 옵션은 타임존 세팅을 하지 않으며, 그리니치 평균시를 사용하게 된다. 한국 시간은 이 시간을 기준으로 +9시간이 된다.
```yml
environment:
    MYSQL_INITDB_SKIP_TZINFO:
```
- 위와 같이 비어 있다면 

```yml
environment:
    MYSQL_INITDB_SKIP_TZINFO: zxcv
```

### 최종 도커 세팅
```yml
version: '3.9'

services:

  db:
    image: mysql
    command: --default-authentication-plugin=caching_sha2_password
    restart: always
    ports:
      - ${DB_PORT}:3306
    environment:
      MYSQL_DATABASE: $DB_DATABASE
      MYSQL_ROOT_PASSWORD: $DB_ROOT_PASSWORD
      MYSQL_USER: $DB_USERNAME
      MYSQL_PASSWORD: $DB_PASSWORD
```
- `$DB_PASSWORD`를 `DB_ROOT_PASSWORD`로 바꾸고 `.env`에 `DB_ROOT_PASSWORD` 환경 변수 값을 세팅해 준다.
- 라라벨의 디폴트 `.env`는 `DB_USERNAME=root`와 `DB_PASSWORD=root`이다. `DB_USERNAME=user`, `DB_PASSWORD=********`으로 바꾸자.

### 데이터베이스에 접근할 수 없을 때
```
php artisan config:cache
```
- 변경한 환경 변수가 반영이 안 되는 경우가 있다.
- 이 경우에는 위 명령어를 사용하여 환경변수를 재설정하도록 하자.
