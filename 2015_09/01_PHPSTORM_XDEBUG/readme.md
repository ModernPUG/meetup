# PhpStorm 과 XDebug

# XDebug 설치

## Client
brew install php56-xdebug

<pre>
$ php -v
PHP 5.6.11 (cli) (built: Jul 30 2015 18:20:18)
Copyright (c) 1997-2015 The PHP Group
Zend Engine v2.6.0, Copyright (c) 1998-2015 Zend Technologies
    with Xdebug v2.3.3, Copyright (c) 2002-2015, by Derick Rethans
</pre>

## Remote machine
$ sudo apt-get install php5-xdebug

`php.ini`
<pre>
  zend_extension=xdebug.so
  xdebug.remote_enable=1
  xdebug.remote_connect_back=1
</pre>

## 브라우저
1. PhpStorm에서 권장하는 북마클릿

https://www.jetbrains.com/phpstorm/marklets/

2. xdebug 확장 검색

https://chrome.google.com/webstore/search/xdebug?hl=ko&_category=extensions

## 트러블슈팅

패스매핑
https://confluence.jetbrains.com/display/PhpStorm/Validating+Your+Debugging+Configuration

[v] Force break at first line when no path mapping specified

[v] Force break at first line when a script is outside of project



# 참고 :

설치 : https://confluence.jetbrains.com/display/PhpStorm/Xdebug+Installation+Guide

윈도우 설명 : https://www.jetbrains.com/phpstorm/help/debug-tool-window.html

동영상 1 : https://www.youtube.com/watch?v=-Z_7ShOI16M&list=PLQ176FUIyIUbfeFz-2EbDzwExRlD0Bc-w&index=11

동영상 2 : https://www.youtube.com/watch?v=rqDDJfG6ip4&list=PLQ176FUIyIUbfeFz-2EbDzwExRlD0Bc-w&index=13
