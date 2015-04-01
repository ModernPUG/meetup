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
- 현재 PHP에서는 error 와 exception 이라는 두가지 오류 형태를 관리한다.

#### 에러와 예외 처리
php 에서는 두가지 형태의 오류를 핸들링한다.

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

[error handler](error_handler/error_handler.php)



### See also

![http://www.somethingofthatilk.com/index.php?id=202](http://www.somethingofthatilk.com/comics/202.jpg)

![pokemon excepton handling](http://icetea09.com/wp-content/uploads/2014/05/exception-example.jpg)
포켓몬 예외 핸들링 (뽑아서 뭐가 나올지 모른다!)

http://c2.com/cgi/wiki?PokemonExceptionHandling
http://c2.com/cgi/wiki?YodaExceptionHandling
