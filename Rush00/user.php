<?php

session_start();

include 'install.php';

function correct_user($username, $pw)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
			if ($user[0] == $username && $user[1] == hash('whirlpool', $pw))
				return TRUE;
		return FALSE;
	}
	fclose($userfile);
}

function login_user($username)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
			if ($user[0] == $username)
				$level = $user[2];
	}
	fclose($userfile);
	$_SESSION['username'] = $username;
	$_SESSION['level'] = $level;
}
if ($_POST['createuser'] == "Create my account")
{
	if ($_POST['username'] == NULL || $_POST['passwd'] == NULL || $_POST['rpasswd'] == NULL)
		die(header("location:sign-in.php?signInFailed=true&reason=blank"));
	if ($_POST['rpasswd'] != $_POST['passwd'])
		die(header("location:sign-in.php?signInFailed=true&reason=rpasswd"));
	if (strlen($_POST['passwd']) < 6)
		die(header("location:sign-in.php?signInFailed=true&reason=notstrong"));
	if (user_exists($_POST['username']) == FALSE)
	{
		if (!ctype_alpha($_POST['username']))
			die(header("location:sign-in.php?signInFailed=true&reason=baduser"));
		create_user($_POST['username'], $_POST['passwd'], "basic");
	}
	else
		die(header("location:sign-in.php?signInFailed=true&reason=user"));
}
else if ($_POST['submit'] == "Log-In")
{
	if ($_POST['login'] == NULL || $_POST['pw'] == NULL)
		die(header("location:index.php?loginFailed=true&reason=blank"));
	if (user_exists($_POST['login']) == FALSE)
		die(header("location:index.php?loginFailed=true&reason=user"));
	if (correct_user($_POST['login'], $_POST['pw']))
		login_user($_POST['login'], $_POST['pw']);
	else
		die(header("location:index.php?loginFailed=true&reason=passwd"));
}
die(header("location:index.php"));
?>