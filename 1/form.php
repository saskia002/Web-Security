<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$self = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES | ENT_HTML5);
$allowed_user = array(
	'username' => 'user',
	'password' => 'pass',
);

function init_session(): void {
	session_name('__Host-Saskia');

	session_set_cookie_params(
		time() + 3600,
		'/',
		'',
		true,
		true
	);
	session_start();
}

function destroy_session(): void {
	if (session_status() === PHP_SESSION_NONE) {
		init_session();
	}

	$params = session_get_cookie_params();
	setcookie(
		session_name(),
		'',
		time() - 9999,
		$params['path'],
		$params['domain'],
		$params['secure'],
		$params['httponly']
	);

	session_unset();
	session_destroy();

}

function getLoginForm(string $error = ''): string {
	global $self;

	$form = <<<HTML
		<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='UTF-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<title>Login from</title>
		</head>
		<body>
			<h2>Login</h2>
			<p style='color:red;'>{$error}</p>

			<form id='loginForm' method='POST' action='{$self}'>
				<label for='username'>Username:</label>
				<br>
				<input type='text' id='username' name='username' >
				<br>
				<label for='password'>Password:</label>
				<br>
				<input type='password' id='password' name='password' >
				<br><br>
				<input type='submit' value='Submit'>
			</form>

			<script>
				document.getElementById('loginForm').addEventListener('submit', validateForm);

				function validateForm(e) {
					const username = document.getElementById('username').value.trim();
					const password = document.getElementById('password').value.trim();

					if (!username || !password) {
						e.preventDefault();
						alert('Both fields are required.');
					}
					e.target.submit();
				};
			</script>
		</body>
		</html>
	HTML;

	return $form;
}


$current_request_method = $_SERVER['REQUEST_METHOD'];
$allowed_request_methods = array('GET', 'POST', );
if (!in_array($current_request_method, $allowed_request_methods)) {
	http_response_code(405);
	$error_message = 'Method Not Allowed: ' . $current_request_method;
	echo ($error_message);
	die();
}

switch ($current_request_method) {
	case 'POST':
		$username = isset($_POST['username']) && !empty($_POST['username']) ?
			htmlspecialchars($_POST['username']) : '';
		$password = isset($_POST['password']) && !empty($_POST['password']) ?
			htmlspecialchars($_POST['password']) : '';


		if ($username === $allowed_user['username'] && $password === $allowed_user['password']) {
			init_session();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;

			echo <<<HTML
				<!DOCTYPE html>
				<html lang='en'>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<title>Hello {$username}!</title>
				</head>
				<body>
					<h2>Hello {$username}!</h2>
					<form method='GET' action='{$self}?action=logout'>
						<input type='hidden' name='action' value='logout'>
						<input type='submit' value='Logout'>
					</form>
				</body>
				</html>
			HTML;

		} else {
			echo getLoginForm('Invalid username or password.');
		}

		break;
	default:
		if (isset($_GET['action']) && !empty($_GET['action'])) {
			$action = htmlspecialchars($_GET['action']);

			if ($action === 'logout') {
				destroy_session();
				header('Location: ' . $self);
			} else {
				echo getLoginForm("Unknown action: {$action}");
			}


		} else {
			echo getLoginForm();
		}

		break;
}
