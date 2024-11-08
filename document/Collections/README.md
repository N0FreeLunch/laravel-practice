## 라라벨 컬렉션

### 목적

라라벨 컬렉션의 공식 문서의 설명은 빈약하다. 문서를 통해서 각각의 컬렉션 메소드가 어떤 역할을 하는지는 알 수 있으나, 다양한 구성의 배열에 대해 정확히 어떻게 처리하는지 공식 문서만의 내용만으로는 알 수 없는 경우가 있다. 각각의 컬렉션에 대한 보다 자세한 내용을 추가하여 컬렉션을 정확하게 사용하게 하기 위한 목적으로 만들어졌다.

### 컬렉션이란?

라라벨의 컬렉션은 php의 배열을 다루기 위한 메소드의 묶음이다. 특별한 데이터 구조를 다루는 것이 아닌, php의 기본 배열인 연관 배열을 다룰 수 있는 도구의 모음이다. 컬렉션 객체는 배열을 받아, 배열을 다루어 특정한 결과를 얻는다.

컬렉션의 메소드 상당수는 php의 배열 관련 내장 함수를 레핑한 경우가 많으므로 컬렉션 메소드의 정확한 동작은 php의 배열 관련 내장함수 쪽에서 확인하는 것이 나을 수 있다.

### 코드 확인 방법

각각의 컬렉션 메소드에 대한 설명은 폴더 단위로 분류하였다. 실행할 수 있는 php 파일과 설명을 위한 README.md 파일을 포함한다.

컬렉션 코드가 담긴 php 코드는 프레임워크와 함께 실행해서 확인해야 하므로 laravel tinker를 이용해서 확인한다. VSCODE를 사용한다면, [tinker 확장 프로그램](https://marketplace.visualstudio.com/items?itemName=tarik02.vscode-tinker)을 사용한다. php 코드 파일을 열고, `cmd` + `shift` + `p`로 VSCODE 검색창을 열어서 `Tinker:run` 명령을 실행하도록 한다.

