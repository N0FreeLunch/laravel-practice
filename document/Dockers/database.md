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
version: '3.1'

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
