<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$arr_cookie_options = array(
	'expires' => time() + 60 * 60 * 24 * 30,
	'path'    => '/web/theme/',
	'domain'  => 'websec.ee',

);

setcookie('theme', 'dark', $arr_cookie_options);

echo ('ur cookies are mine 8-)');