<?php
$src_dir = './src'; // 소스 디렉토리
$build_dir = './build'; // 빌드 디렉토리
$phar_name = 'dmc.phar'; // phar 파일명

$phar_path = "{$build_dir}/{$phar_name}";

@unlink($phar_path); // 이전에 빌드된 phar 파일 삭제

$phar = new Phar($phar_path);
$phar->startBuffering();
$phar = $phar->convertToExecutable(Phar::TAR, Phar::GZ, '.phar');

$phar->buildFromDirectory($src_dir);
$phar->setStub($phar->createDefaultStub('index.php'));

$phar->stopBuffering();
?>
