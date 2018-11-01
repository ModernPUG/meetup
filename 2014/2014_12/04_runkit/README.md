# PHP runkit #

[PHP runkit](http://php.net/manual/en/book.runkit.php)에 대한 소개이다.


## 설치 ##

```
cd /tmp
git clone https://github.com/zenovich/runkit.git
cd runkit
pecl install package.xml

// Add to php.ini:
extension=runkit.so

// Restart your webserver
service httpd restart
```

위의 git 저장소는 5.6에서 오류가 발생했다.
PHP 5.6은 아래의 저장소를 사용하면 된다.

`https://github.com/adrianguenter/runkit.git`

사용법은 PHP 메뉴얼이 킹왕짱!

runkit을 활용하여 만든 클래스 메소드 후킹 예제 참고.

`예제파일: hooking.php`
