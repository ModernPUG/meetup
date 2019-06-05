# MySQL ORDER BY CASE

```sql
CREATE TABLE `test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status-start_at` (`status`,`start_at` DESC),
  KEY `status-end_at` (`status`,`end_at` DESC)
) ENGINE=InnoDB;

INSERT INTO `test` VALUES
    (1,'stop','2019-06-01','2019-06-11'),
    (2,'stop','2019-06-02','2019-06-12'),
    (3,'stop','2019-06-03','2019-06-13'),
    (4,'run','2019-06-04','2019-06-14'),
    (5,'run','2019-06-05','2019-06-15'),
    (6,'run','2019-06-06','2019-06-16')
;
```

```sql
SELECT * FROM test
ORDER BY
    FIELD(`status`, 'run', 'stop'),
    `start_at` DESC
;

SELECT * FROM test
ORDER BY
    FIELD(`status`, 'run', 'stop'),
    `end_at` ASC
;

SELECT * FROM test
ORDER BY
    FIELD(`status`, 'run', 'stop'),
    -- status가 run이면 end_at ACE
    (CASE `status` WHEN 'run' THEN `end_at` END) ASC,
    -- status가 stop이면 end_at DESC
    (CASE `status` WHEN 'stop' THEN `end_at` END) DESC
;
```
