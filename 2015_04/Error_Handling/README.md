# 에러 핸들링
## [에러핸들링 함수](http://php.net/manual/en/ref.errorfunc.php)
- debug_backtrace - 디버깅
- debug_print_backtrace - 디버깅
- error_get_last — 디버깅

- error_log — 로그
- error_reporting — 로그

- set_error_handler — **에러 핸들링**
- restore_error_handler — **에러 핸들링**

- set_exception_handler — **에러 핸들링**
- restore_exception_handler — **에러 핸들링**

- trigger_error(user_error) — **에러 핸들링**

## 디버깅, 로깅, 에러 핸들링

### 디버깅
- 호출 스택을 역추적 한다
- 특별한 상황에서 매우 유용하게 사용될 수 있는 강력한 함수 이지만, 일반적인 상황에서의 남용은 옳지 않다.

### 로깅
- 필요한 시점에 원하는 곳에 정보를 남긴다.
- 유용하고 편리하고 안심이 되지만, 좋은 코드는 로직에 로그를 남기지 않는다.

### 에러 핸들링
- 에러와 예외가 발생했을 경우, 이를 전담해서 처리하도록 한다.
- 로깅과 디버깅은 에러가 발생했을 때, 필요한 경우에 추가 정보를 확인할 수 있는 유용한 도구이다.
- 현재 PHP 에서는 error 와 exception 이라는 두가지 오류 형태를 관리한다.

#### 에러와 예외 처리
php 에서는 에러와 예외 라는 형태의 오류를 핸들링한다.

##### 에러
- set_error_handler()
- restore_error_handler()
- trigger_error()

##### 예외
- set_exception_handler()
- restore_exception_handler()
- throw new MyException()

#### 에러를 예외로 변환하기
두가지 형태의 오류를 제어하기는 두배의 노력이 필요하다.
우리는 이 것을 하나의 형태로 줄임으로써 로직을 단순화 하고, 필요한 관심을 줄일 것이다.

### Practice

http://javierferrer.me/exceptions-vs-error-codes/

#### 에러 코드를 리턴하는 방법
- 리턴 코드 -1, -2, -3 ...
- 핸들링 하는 부분은 `if/elseif/elseif/elseif/.../else` 혹은 `switch-case` 뭉치들
##### 문제점
- 읽기 힘들다.
- 변경시 중복되는 에러 핸들링을 모두 확인하고 고쳐야 한다. (-1 을 -1001로 변경한다면?)

#### 에러 코드 숫자를 의미 있는 상수로 정의
- 읽기 조금 좋아졌다.
- 코드 변경시 좀 더 유연하게 대처가능하다.
##### 문제점
- 내부 코드를 extract method 하거나, 메소드가 계층적으로 호출될 때 마다, 에러값을 고려하고 핸들링 해야 한다.

#### 에러코드를 Exception 사용으로 변경
- 에러 코드를 Exception 의 파라미터로 전달한다.
`throw new \RuntimeException("Invalid credentials", self::INVALID_LOGIN_CREDENTIALS);`
- 에러 코드를 호출 스택 마다 전달해 줘야 하는 문제가 사라졌다.
- 어디서든 필요한 시점에 예외를 처리하면 된다.
##### 문제점
- 포켓몬 예외 핸들링 !
- 모든 RuntimeException 을 catch 한다.
- 심지어 DB 에러가 발생해도 catch 하게 된다.
- 에러 문자열의 중복이 발생한다.

#### 원하는 예외가 아닐 경우, 다시 throw 하도록 변경
- 관련한 코드가 아닐 경우, 예외를 핸들링 할 기회를 다시 부여했기 때문에 문제가 해결되었다.
##### 문제점
- 에러 코드값의 중복이 발생할 경우 로직의 충돌이 발생할 우려가 있다.
- Semantics : 코드상의 의미가 불분명해 질 수 있다. (RuntimeException 의 파라미터로 분기하므로)

#### RuntimeException 을 상속받는 특정 케이스의 Exception 을 생성한다.
- 각 케이스 마다 Exception Class 를 생성하여 로직상 명확하고 의미가 분명해 졌다.
- 각각의 catch 로 처리할 수 있으니 명확하고 충돌이 발생할 수 없다.
##### 문제점
- OCP 위반
- switch-case 구문에서 냄새가 난다. (code smell)
- catch 시리즈도 마찬가지다.
- 유사한 예외가 새로 생길 때 마다 핸들링을 수정해야한다.
- ...

#### abstract class 로 중복을 제거한다.
- 메시지와 코드를 각 클래스 내에서 처리했다.
- 공통적으로 InvalidLoginException 의 처리를 하도록 해서 불필요한 중복을 없앴다.
##### 문제점
- 에러를 처리하는 문제는 깔끔해 졌지만, 하나의 메소드에 너무 많은 로직이 들어있다.

#### 로직을 캡슐화
- 각 예외를 발생하는 로직을 추출하여 가독성이 높아졌다.
- 다른 코드에서도 동일한 로직을 재사용 할 수 있고, 에러를 핸들링 하는 방법도 통일되었다.

##### 결론 
- 좋아졌다.
- 상황에 맞게 적당한 수준에서 써야 한다. (오버엔지니어링 주의)

### See also

![http://www.somethingofthatilk.com/index.php?id=202](http://www.somethingofthatilk.com/comics/202.jpg)

![pokemon exception handling](http://icetea09.com/wp-content/uploads/2014/05/exception-example.jpg)
포켓몬 예외 핸들링 (뽑아서 뭐가 나올지 모른다!)

http://c2.com/cgi/wiki?PokemonExceptionHandling
http://c2.com/cgi/wiki?YodaExceptionHandling
