<?php
namespace Traits;

trait Property
{
    /**
     * 클래스 스스로가 호출한 것인지 여부
     * @return boolean
     */
    private static function isCalledSelf()
    {
        $callers = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        return isset($callers[2]['class']) && $callers[2]['class'] == get_called_class();
    }

    /** @var 비공개 프로퍼티 */
    private $_private = [];
    /** @var 공개 프로퍼티 */
    private $_public = [];
    /** @var getter */
    private $_getter = [];
    /** @var setter */
    private $_setter = [];

    /**
     * 모든 프로퍼티 삭제
     */
    private function removeAllProperty()
    {
        $this->_private = [];
        $this->_public = [];
        $this->_getter = [];
        $this->_setter = [];
    }

    /**
     * $this->_name 을 다루는 getter/setter 를 만든다.
     * @param string/array $name_list 이름
     * @param boolean $is_readonly 읽기전용 여부
     */
    private function synthesize($name_list, $is_readonly = false)
    {
        $name_list = (array)$name_list;

        foreach ($name_list as $name) {
            unset($this->_public[$name]);

            if (! array_key_exists($name, $this->_private)) {
                $this->_private[$name] = null;
            }

            $this->_getter[$name] = true;

            if ($is_readonly) {
                unset($this->_setter[$name]);
            } else {
                $this->_setter[$name] = true;
            }
        }
    }

    /**
     * 읽기/쓰기 프로퍼티 선언
     * @param string/array $name_list 이름
     */
    public function readwrite($name_list)
    {
        $this->synthesize($name_list);
    }

    /**
     * 읽기 전용 프로퍼티 선언
     * @param string/array $name_list 이름
     */
    public function readonly($name_list)
    {
        $this->synthesize($name_list, true);
    }

    /**
     * getter 선언
     * @param string $name 이름
     * @param Closure $closure 클로저
     */
    private function getter($name, \Closure $closure)
    {
        unset($this->_public[$name]);

        $this->_getter[$name] = $closure;
    }

    /**
     * 클로저가 최초 한번만 실행되며 이후에는 최초 실행된 값만 반환하는 getter 선언
     * @param string $name 이름
     * @param Closure $closure 클로저
     */
    private function getterOnce($name, \Closure $closure)
    {
        unset($this->_public[$name]);

        $this->_getter[$name] = function () use (&$closure) {
            static $is_call = false;
            static $result;

            if (! $is_call) {
                $result = $closure();
                $is_call = true;
            }

            return $result;
        };
    }

    /**
     * setter 선언
     * @param string $name 이름
     * @param Closure $closure 클로저
     */
    private function setter($name, \Closure $closure)
    {
        unset($this->_public[$name]);

        if (! array_key_exists($name, $this->_getter)) {
            $this->readonly($name);
        }
        $this->_setter[$name] = $closure;
    }

    /**
     * __get
     * @param string $name 이름
     * @return mixed
     */
    public function __get($name)
    {
        if (strpos($name, '_') === 0) {
            if (! self::isCalledSelf()) {
                trigger_error("'{$name}' property is private.", E_USER_ERROR);
            }

            return $this->_private[substr($name, 1)];
        }

        if (array_key_exists($name, $this->_public)) {
            return $this->_public[$name];
        }

        if (array_key_exists($name, $this->_getter)) {
            if ($this->_getter[$name] instanceof \Closure) {
                return $this->_getter[$name]();
            } else {
                return $this->_private[$name];
            }
        }

        return;
    }

    /**
     * __set
     * @param string $name 이름
     * @param mixed $value 값
     */
    public function __set($name, $value)
    {
        // 호출자가 클래스 자신인지 여부
        $is_self_class = self::isCalledSelf();

        if (strpos($name, '_') === 0) {
            if (! $is_self_class) {
                trigger_error("'{$name}' property is private.", E_USER_ERROR);
            }

            $this->_private[substr($name, 1)] = $value;
            return;
        }

        // setter가 있으면 호출
        if (array_key_exists($name, $this->_setter)) {
            if ($this->_setter[$name] instanceof \Closure) {
                $this->_setter[$name]($value);
            } else {
                $this->_private[$name] = $value;
            }
            return;
        }

        // setter는 없고 getter만 있으면 읽기전용.
        if (array_key_exists($name, $this->_getter)) {
            if (! $is_self_class) {
                trigger_error("'{$name}' property is readonly.", E_USER_ERROR);
            }

            $this->_private[$name] = $value;
            return;
        }

        // 공개 프로퍼티가 아니면
        if (! array_key_exists($name, $this->_public)) {
            // 읽기전용 프로퍼티 생성
            if ($is_self_class) {
                $this->_private[$name] = $value;
                $this->readonly($name);
                return;
            }
        }

        // 공개 프로퍼티 추가
        $this->_public[$name] = $value;
    }

    /**
     * __isset
     * @param string $name 이름
     * @return boolean
     */
    public function __isset($name)
    {
        if (strpos($name, '_') === 0) {
            return isset($this->_private[substr($name, 1)]);
        }

        return isset($this->_public[$name])
            || isset($this->_getter[$name]);
    }

    /**
     * __unset
     * @param string $name 이름
     * @return boolean
     */
    public function __unset($name)
    {
        if (! array_key_exists($name, $this->_public)) {
            // 호출자가 클래스 자신인지 여부
            if (! self::isCalledSelf()) {
                trigger_error("cannot unset '{$name}' property.", E_USER_ERROR);
            }
        }

        if (strpos($name, '_') === 0) {
            unset($this->_private[substr($name, 1)]);
        } else {
            unset($this->_private[$name]);
            unset($this->_public[$name]);
            unset($this->_getter[$name]);
            unset($this->_setter[$name]);
        }
    }

    /**
     * 데이터 병합
     * @param mixed $data
     * @return object
     */
    public function merge($data)
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }

        return $this;
    }

    /**
     * Required definition of interface IteratorAggregate
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        foreach ((new \ArrayObject($this)) as $key => $value) {
            yield $key => $value;
        }

        foreach ($this->_public as $key => $value) {
            yield $key => $value;
        }

        foreach ($this->_getter as $key => $value) {
            yield $key => $this->$key;
        }
    }

    /**
     * __toString
     * @return string
     */
    public function __toString()
    {
        $str_list = array();

        $str_list[] = get_class($this) . ' Object';
        $str_list[] = '(';

        $fn_display = function ($key) use (&$str_list) {
            $value = $this->$key;

            $ro = array_key_exists($key, $this->_getter) && ! array_key_exists($key, $this->_setter) ? '@' : '';

            $str = "\t[{$key}]{$ro} => ";
            if (is_scalar($value)) {
                $str .= $value;
            } elseif (is_array($value)) {
                $str .= 'Array';
            } elseif (is_object($value)) {
                $str .= get_class($value) . ' Object';
            } else {
                $str .= gettype($value) . ' Type';
            }

            $str_list[] = $str;
        };

        foreach (new \ArrayObject($this) as $key => $value) {
            $fn_display($key);
        }

        foreach ($this->_public as $key => $value) {
            $fn_display($key);
        }

        foreach ($this->_getter as $key => $value) {
            $fn_display($key);
        }

        $str_list[] = ')';

        return implode("\n", $str_list) . "\n";
    }
}

