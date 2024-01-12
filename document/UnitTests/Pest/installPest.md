## Pest 설치

1. 패키지 설치
```
composer require pestphp/pest --dev --with-all-dependencies
```

> Do you trust "pestphp/pest-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?]  y

2. pest 설정 파일 설치
```
INFO  File `phpunit.xml` already exists, skipped.
DONE  Created `tests/Pest.php` file.
DONE  Created `tests/ExampleTest.php` file.

DONE  Pest initialised.
```

3. pest 실행 해 보기
```
./vendor/bin/pest
```
