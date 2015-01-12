<?php
namespace Pug\Example;

use Slim\Slim;

class Simple
{
	private $app;

	public function __construct(Slim $app)
	{
		$this->app = $app;

		$this->app->response->headers->set("Content-Type", "text/plain");

		$this->app->response->headers->set('Access-Control-Allow-Origin', '*');
		$this->app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
		$this->app->response->headers->set('Access-Control-Allow-Credentials', 'true');
		$this->app->response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
	}

	public function normalLogin()
	{
		session_start();

		$_SESSION['id'] = "wan2land";
		$_SESSION['name'] = "하핫 :)";

		echo "성공";
	}

	public function normalMe()
	{
		session_start();

		print_r($_SESSION);
	}

	public function corsLogin()
	{
		ini_set('session.use_cookies', 0);
		ini_set('session.use_only_cookies', 0);
		ini_set('session.use_trans_sid', 1);

		session_name("pug_session");
		session_start();

		$_SESSION['id'] = "wan2land";
		$_SESSION['name'] = "하핫..;;";

		echo session_id();
	}


	public function corsMe()
	{
		ini_set('session.use_cookies', 0);
		ini_set('session.use_only_cookies', 0);
		ini_set('session.use_trans_sid', 1);

		session_name("pug_session");
		session_start();

		print_r($_SESSION);

	}


	public function showStatus()
	{
		echo "\$_SERVER --\n";
		print_r($_SERVER);

		echo "\n\n\$_POST--\n";
		print_r($_POST);

		echo "\n\n\$_GET--\n";
		print_r($_GET);

		echo "\n\nphp://input --\n";
		print_r(file_get_contents("php://input"));
	}
}