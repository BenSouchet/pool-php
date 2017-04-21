<?php
/*
** file functions
*/
$PRIVATE_DIR = "../private/";
function load_from_file($file_name)
{
	global $PRIVATE_DIR;
	$file_name = $PRIVATE_DIR . $file_name;
	if (($f = @fopen($file_name, "r")) === FALSE)
		return ([]);
	if (!flock($f, LOCK_SH))
		$data = [];
	else
		$data = @unserialize(@file_get_contents($file_name));
	fclose($f);
	if ((array)$data !== $data)
		return ([]);
	return ($data);
}
function save_to_file($file_name, $data)
{
	global $PRIVATE_DIR;
	$file_name = $PRIVATE_DIR . $file_name;
	if ((!file_exists($PRIVATE_DIR) && !@mkdir($PRIVATE_DIR))
		|| ($f = fopen($file_name, "w")) === FALSE)
		return (FALSE);
	$ok = FALSE;
	if (flock($f, LOCK_EX))
	{
		if (@file_put_contents($file_name, serialize($data)) !== FALSE)
			$ok = TRUE;
		flock($f, LOCK_UN);
	}
	fclose($f);
	return ($ok);
}
/*
** auth functions
*/
$PASSWD_FILE = "passwd";
$PASSWD_HASH = "whirlpool";
function load_users()
{
	global $PASSWD_FILE;
	return (load_from_file($PASSWD_FILE));
}
function save_users($users)
{
	global $PASSWD_FILE;
	return (save_to_file($PASSWD_FILE, $users));
}
function user_get($users, $login)
{
	foreach ($users as $user_data)
		if ($user_data["login"] == $login)
			return ($user_data);
	return (FALSE);
}
function user_chpasswd($users, $login, $old_passwd, $new_passwd)
{
	global $PASSWD_HASH;
	if ($login == "" || $old_passwd == "" || $new_passwd == "")
		return (FALSE);
	for ($i = 0; $i < count($users); $i++)
	{
		if ($users[$i]["login"] == $login)
		{
			if ($users[$i]["passwd"] != hash($PASSWD_HASH, $old_passwd))
				return (FALSE);
			$users[$i]["passwd"] = hash($PASSWD_HASH, $new_passwd);
			return ($users);
		}
	}
	return (FALSE);
}
function user_add($users, $login, $passwd)
{
	global $PASSWD_HASH;
	if ($login === "" || $passwd === ""
		|| user_get($users, $login) !== FALSE)
		return (FALSE);
	$users[] = array(
		"login" => $login,
		"passwd" => hash($PASSWD_HASH, $passwd)
	);
	return ($users);
}
function auth($login, $passwd)
{
	global $PASSWD_HASH;
	return (($users = $users = load_users()) !== FALSE
		&& ($user = user_get($users, $login)) !== FALSE
		&& $user["passwd"] == hash($PASSWD_HASH, $passwd));
}
?>
