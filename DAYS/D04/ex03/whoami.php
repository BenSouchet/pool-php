<?php
session_start();
echo (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] != "") ? $_SESSION["loggued_on_user"] ."\n" : "ERROR\n";
?>
