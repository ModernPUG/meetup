# static 활용
​
클래스의 객체들이 서로 공통으로 사용하는 값(또는 객체)을 공유하는 예제
​
## 일반적인 방법
​
static 멤버 변수와 메소드를 사용하여 구현
​
```php
class Bar
{
    private static $obj;
​
    // 정적 메소드
    private static function getObj()
    {
        if (!self::$obj) {
            echo "한번만 생성됨\n";
            $obj = new DateTime();
        }
​
        return $obj;
    }
​
    // 객체의 메소드
    public function foo()
    {
        $obj = self::getObj();
​
        echo $obj->format('Y-m-d H:i:s') . "\n";
    }
}
​
$bar = new Bar();
$bar->foo();
$bar->foo();
```
​
## 객체의 메소드내에 static 선언 사용
​
사용처가 국한적인 경우에 유용
​
```php
class Bar
{
    // 객체의 메소드
    public function foo()
    {
        static $obj;
​
        if (!$obj) {
            echo "한번만 생성됨\n";
            $obj = new DateTime();
        }
​
        echo $obj->format('Y-m-d H:i:s') . "\n";
}
​
$bar = new Bar();
$bar->foo();
$bar->foo();
```
​
## 3항 연산자로 짧게 표현하기
​
바로 위의 코드에서 if문 대신 3항 연산자 사용
​
```php
class Bar
{
    public function foo()
    {
        static $obj;
​
        $obj = $obj ?: new DateTime();
​
        echo $obj->format('Y-m-d H:i:s') . "\n";
}
```