#!/usr/bin/php
<?php
if ($argc != 2)
	exit;
$argv[1] = trim(preg_replace("/\s+/", " ", $argv[1]));
echo $argv[1]."\n";
?>
