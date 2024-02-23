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


## inertia 설치
Frontend 폴더
```
pnpm install @inertiajs/react
```

리포지토리 메인 폴더에서
```
composer require inertiajs/inertia-laravel
```


