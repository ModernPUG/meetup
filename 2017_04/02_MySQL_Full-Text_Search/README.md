# MySQL Full-Text 검색

## Full-Text 검색

전체 텍스트를 인덱싱하고 검색할 수 있는 기능.
간단히 말해서 검색엔진 같은거.

## 전문 검색엔진 대비 MySQL 이용의 장점

MySQL 쓴다는 그 자체가 장점.
MySQL에서 하던 것 그대로 다 할 수 있음.

## 어떻게 하면 되는데?

1. 검색하고 싶은 컬럼의 FULLTEXT 인덱스를 만든다.
2. 그리고 Full-Text 검색용 함수로 검색한다.

## FULLTEXT 인덱스

INDEX, UNIQUE, SPATIAL 등과 같은 인덱스의 종류

```sql
CREATE TABLE
...생략...
FULLTEXT KEY `인덱스명` (`컬럼명`)
) ENGINE=InnoDB;
```

## ngram 파서

그냥 FULLTEXT 인덱스 선언만으로는 한글 검색이 안된다.
한글 검색을 하려면 ngram 파서를 사용해야 한다.

```sql
FULLTEXT KEY `인덱스명` (`컬럼명`) WITH PARSER `ngram`
```

## N-gram?

'abcd'를 N-gram으로 파싱한다면 아래와 같다.

```
N = 1: 'a', 'b', 'c', 'd'
N = 2: 'ab', 'bc', 'cd'
N = 3: 'abc', 'bcd'
N = 4: 'abcd'
```

## 실습용 테이블 생성과 더미 데이터 넣기

테이블 스키마는 아래와 같고 더미 데이터는 잘 넣는다.

```sql
CREATE TABLE test.`post2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `content` (`content`) WITH PARSER `ngram`
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## 인덱싱 결과를 보자

```sql
-- MySQL innodb_ft_aux_table 시스템 변수에 DB/테이블 지정
SET GLOBAL innodb_ft_aux_table="test/post2";

-- INFORMATION_SCHEMA.INNODB_FT_INDEX_CACHE 내용 확인
SELECT * FROM INFORMATION_SCHEMA.INNODB_FT_INDEX_CACHE
ORDER BY doc_id, position;
```

## 검색 쿼리

### NATURAL LANGUAGE MODE

별거 없음.

```sql
SELECT * FROM test.post2
WHERE MATCH (content) AGAINST ('청춘' IN NATURAL LANGUAGE MODE);
```

### BOOLEAN MODE

- \+ : 반드시 포함

- \- : 제외

- \* : 부분 검색

```sql
SELECT * FROM test.post2
WHERE MATCH (content) AGAINST ('+청춘 -이성 인류*' IN BOOLEAN MODE)
```

### 공통

- "" : 묶어서 한 단어

```sql
SELECT * FROM test.post2
WHERE MATCH (content) AGAINST ('"힘차게 피고"' IN BOOLEAN MODE)
```

### 유사도 점수

```sql
SELECT
  id,
  MATCH (content) AGAINST ('+청춘' IN BOOLEAN MODE) 점수,
  content
FROM test.post2
WHERE MATCH (content) AGAINST ('+청춘' IN BOOLEAN MODE);
```

유사도 점수를 이용해서 글의 본문과 제목을 검사 후 글의 제목에는 점수를 더 주는 방법으로 검색 순위에 차등을 줄 수 있음.

## MeCab 파서

형태소 분석이 가능한 파서.

자세한 설명은 링크로 대신.
https://dev.mysql.com/doc/refman/5.7/en/fulltext-search-mecab.html

여기에 은전한닢 프로젝트의 한글 사전을 넣어주면 MeCab 파서로 한글 형태소 분석이 가능할 것 같지만 안해봤습니다.

## 끝

ModernPUG 정모는 2차가 진짜.
