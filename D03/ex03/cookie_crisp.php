<?php
if ($_GET)
{
	if ($_GET['action'] == "set")
		setcookie($_GET['name'], $_GET['value'], time() + (24 * 60 * 60));
	else if ($_GET['action'] == "get" && $_COOKIE[$_GET['name']] != NULL)
		echo ($_COOKIE[$_GET['name']])."\n";
	else if ($_GET['action'] == "del")
		setcookie($_GET['name'], "", -1);
}
?>
