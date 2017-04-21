<?php
if ($_POST['login'] == NULL ||
	$_POST['oldpw'] == NULL ||
	$_POST['newpw'] == NULL ||
	$_POST['oldpw'] == $_POST['newwd'] ||
	$_POST['submit'] != "OK" ||
	!file_exists("../private/passwd"))
	die("ERROR\n");
function edit_password_user($file_passwd, $array_user, $array_users)
{
	$i = -1;
	while ($array_users[++$i])
	{
		if ($array_users[$i]['login'] == $array_user['login'] &&
		$array_users[$i]['passwd'] == $array_user['oldpw'])
		{
			$array_users[$i]['passwd'] = $array_user['newpw'];
			file_put_contents($file_passwd, serialize($array_users));
			return (0);
		}
	}
	return (1);
}
$array_user['login'] = $_POST['login'];
$array_user['oldpw'] = hash("whirlpool", $_POST['oldpw']);
$array_user['newpw'] = hash("whirlpool", $_POST['newpw']);
$file_passwd = "../private/passwd";
$array_users = file_get_contents($file_passwd);
if (!$array_users)
	die("ERROR\n");
if (edit_password_user($file_passwd, $array_user, (array)unserialize($array_users)))
	die("ERROR\n");
echo "OK\n";
?>
