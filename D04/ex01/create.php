<?php
if ($_POST['login'] == NULL || $_POST['passwd'] == NULL || $_POST['submit'] != "OK")
	die("ERROR\n");
function check_user($login, $array_users)
{
	foreach ($array_users as $user)
		if ($user['login'] == $login)
			return (1);
	return (0);
}
$array_user['login'] = $_POST['login'];
$array_user['passwd'] = hash("whirlpool", $_POST['passwd']);
$file_passwd = "../private/passwd";
if (!file_exists("../private/"))
	mkdir("../private/");
if (file_exists($file_passwd))
{
	$array_users = file_get_contents($file_passwd);
	if (check_user($_POST['login'], (array)unserialize($array_users)))
		die("ERROR\n");
	if ($array_users)
		$array_users = unserialize($array_users);
}
$array_users[] = $array_user;
$array_users = serialize($array_users);
file_put_contents($file_passwd, $array_users);
echo "OK\n";
?>
