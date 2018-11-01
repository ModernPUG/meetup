<?php
include __DIR__.'/vendor/autoload.php';

deployer();

define('LOCAL_ROOT', __DIR__);
define('BUILD_NAME', 'example_'.date('ymd_H') );

ignore(array(
	'deployer.php',
	'composer.json',
	'composer.lock'
));

task('init-master', '본서버에 사용할 값들을 정의합니다.', function() {
	define('SERVER_HOST', 'pug1');
	define('SERVER_ID', 'wani');
	define('SERVER_PASSWORD', 'macNew131108!');

	define('REMOTE_ROOT', '/Users/Shared/Sites');
	define('REMOTE_WWW', 'pug1');
});


task('connect', '서버에 접속합니다.', function() {
	connect( SERVER_HOST, SERVER_ID, SERVER_PASSWORD );
});

task('upload', "서버에 파일을 업로드 합니다.", function() {

	cd( REMOTE_ROOT );

	run('rm -rf '.BUILD_NAME);
	upload( LOCAL_ROOT, REMOTE_ROOT.'/'.BUILD_NAME );

	run('rm '.REMOTE_WWW);
	run('ln -s '.BUILD_NAME.' '.REMOTE_WWW);
});

task('master-deploy', '마스터 서버에 배포합니다.', ['init-master', 'connect', 'upload']);

start();
