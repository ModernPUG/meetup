# MySQL Spatial Data

## Spatial 사전적 의미

- 공간의
- 공간적인
- 장소의

## 용어 사전

- GIS
    > 지리 정보 체계(地理情報體系, 영어: geographic information system, GIS)

- OGS
    > OGC (Open Geospatial Consortium)는 공개적으로 사용 가능한 인터페이스 표준을 개발하기 위해 합의 프로세스에 참여하는 521 개 이상의 회사, 정부 기관 및 대학교의 국제 산업 컨소시엄

- OpenGIS
    > 네트워크 환경에서 이기종 지리 데이터 및 지오 프로세싱 리소스에 대한 투명한 액세스를 지원하는 OGC의 합의 프로세스의 사양 및 기타 제품을 설명하는 형용사
    http://www.opengeospatial.org/ogc/faq/openness/#1

- WKB(Well-Known Binary)
    > http://www.gisdeveloper.co.kr/?p=997

- WKT(Well-Known Text)
    > http://www.gisdeveloper.co.kr/?p=994

## 데이터 종류

- GEOMETRY
- POINT
- LINESTRING
- POLYGON
- MULTIPOINT
- MULTILINESTRING
- MULTIPOLYGON
- GEOMETRYCOLLECTION

## 학습 목표

당장 필요한 GEOMETRY 관련 내용만 쏙 빼먹기

## 실습 DB 준비

### 장소 테이블 생성

```sql
CREATE TABLE `venue` (
    `name` VARCHAR(45) NOT NULL,
    `lnglat` GEOMETRY NOT NULL,
    PRIMARY KEY (`name`),
    SPATIAL KEY `lnglat` (`lnglat`)
) ENGINE=InnoDB;
```

- 컬럼
  - name: 장소명
  - lnglat: 경도/위도, GEOMETRY 데이터형

- 인덱스
  - lnglat: SPATIAL 인덱스

### 장소 데이터 추가

```sql
INSERT INTO venue (name, lnglat) VALUES
    ('영신한의원', POINT(126.929257, 37.484405)),
    ('이니스프리 신림점', POINT(126.929056, 37.484271)),
    ('JOYDVD', POINT(126.928777, 37.484401));
```

'경도/위도'는 'X/Y좌표' 이므로 POINT() 함수로 값을 넣을 수 있다.

### 데이터 확인

```sql
SELECT * FROM test.venue;
```

```sql
SELECT *, ST_AsText(lnglat) FROM test.venue;
```

ST_AsText() 함수를 사용하면 사람이 볼 수 있는 형태로 출력

## 실습

[MySQL Spatial 함수 레퍼런스](https://dev.mysql.com/doc/refman/5.7/en/spatial-function-reference.html)

### 거리 측정

ST_Distance_Sphere() 함수로 두 위치 좌표간 거리를 meter로 반환

```sql
SELECT ST_Distance_Sphere(
    POINT(126.929257, 37.484405),
    POINT(126.929056, 37.484271)
);
```

### 사각 영역에 포함되는 장소 찾는 방법

1. ST_MakeEnvelope() 함수로 사각 영역을 만든다.

    ```sql
    ST_MakeEnvelope(좌표1, 좌표2)
    ```

2. ST_Within() 함수로 대상 좌표가 사각 영역에 포함되는지 확인한다.

    ```sql
    ST_Within(대상 좌표, ST_MakeEnvelope(좌표1, 좌표2))
    ```

### 사각 영역에 포함되는 장소 찾기 실습

```sql
SELECT * FROM venue
WHERE
    ST_Within(
        lnglat,
        ST_MakeEnvelope(
            POINT(126.928952, 37.484590),
            POINT(126.929552, 37.484201)
        )
    )
;
```

### 폴리곤 영역에 포함되는 장소 찾기

#### WKT 방식
```sql
SELECT * FROM test.venue
WHERE
    ST_Within(
        lnglat,
        ST_GeomFromText('
            Polygon((
                126.928754 37.484526,
                126.928671 37.484256,
                126.928929 37.484311,
                126.928754 37.484526
            ))
        ')
    )
```

#### WKB 방식
```sql
SELECT * FROM venue
WHERE
    ST_Within(
        lnglat,
        ST_GeomFromWKB(
            POLYGON(LineString(
                POINT(126.928754, 37.484526),
                POINT(126.928671, 37.484256),
                POINT(126.928929, 37.484311),
                POINT(126.928754, 37.484526)
            ))
        )
    )
```

## MySQL Workbench Spatial View

### 참고 자료

- [MySQL Workbench 6.2: Spatial Data](http://mysqlworkbench.org/2014/09/mysql-workbench-6-2-spatial-data/)

- [I’m really quite good with maps](http://thenoyes.com/littlenoise/?p=444)

- [Download free shapefile maps](https://www.statsilk.com/maps/download-free-shapefile-maps)

## 끝

~~Modern MySQL User Group~~ ModernPUG 정모는 2차가 진짜.
