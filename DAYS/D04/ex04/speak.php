<?php

include "auth.php";

if (isset($_POST["msg"]) && $_POST["msg"] != "")
{
	session_start();

	if (!isset($_SESSION["loggued_on_user"]) || $_SESSION["loggued_on_user"] == "")
	{
		echo "ERROR\n";
		exit(1);
	}

	date_default_timezone_set("Europe/Paris");
	$messages = load_from_file("chat");
	$messages[] = array(
		"login" => $_SESSION["loggued_on_user"],
		"time" => time(),
		"msg" => $_POST["msg"]
	);
	if (!save_to_file("chat", $messages))
	{
		echo "ERROR\n";
		exit(1);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>speak</title>
	<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
</head>
<body style="margin:0;overflow:hidden;">

<form action="speak.php" method="POST">
	<input style="width:100vw;height:90vh;" type="text" name="msg" />
</form>

</body>
</html>
