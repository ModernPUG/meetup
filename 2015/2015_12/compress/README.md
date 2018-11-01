# 초간단 PHP 압축 프로그램

## 압축 알고리즘

무손실 압축 알고리즘중 가장 기초적인 것으로 반복되는 바이트를 줄여쓰는 알고리즘
> AAABBBBCCCCC => A2B3C3

## 예제 코드 실행

### 압축하기
1.bmp 파일을 1.tmp 라는 파일로 압축하기
> $ php run.php c 1.tmp 1.bmp

### 압축풀기
1.tmp 라는 파일을 2.bmp로 압축풀기
> $ php run.php x 1.tmp 2.bmp