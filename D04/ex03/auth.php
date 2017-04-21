<?php
$PRIVATE_DIR = "../private";
$PASSWD_FILE = "../private/passwd";
$PASSWD_HASH = "whirlpool";
function load_users()
{
	global $PASSWD_FILE;
	if (!file_exists($PASSWD_FILE))
		return ([]);
	$users = @unserialize(@file_get_contents($PASSWD_FILE));
	if ((array)$users !== $users)
		return ([]);
	return ($users);
}
function save_users($users)
{
	global $PASSWD_FILE;
	global $PRIVATE_DIR;
	return ((file_exists($PRIVATE_DIR) || @mkdir($PRIVATE_DIR))
		&& @file_put_contents($PASSWD_FILE, serialize($users)) !== FALSE);
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
