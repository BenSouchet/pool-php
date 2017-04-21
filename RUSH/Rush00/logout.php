<?php
session_start();
if ($_SESSION['username'] != NULL)
	$_SESSION['username'] = NULL;

if ($_SESSION['level'] != NULL)
	$_SESSION['level'] = "guest";

if ($_SESSION['basket'] != NULL)
	$_SESSION['basket'] = NULL;

die(header("location:index.php"));
?>
