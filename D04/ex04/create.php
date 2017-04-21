<?php

include "auth.php";

if (isset($_POST["submit"]) && $_POST["submit"] == "OK"
	&& ($users = load_users()) !== FALSE
	&& ($users = user_add($users, $_POST["login"], $_POST["passwd"])) !== FALSE
	&& save_users($users))
{
	header("Location: index.html");
	echo "OK\n";
}
else
{
	header("Location: create.html");
	echo "ERROR\n";
}

?>
