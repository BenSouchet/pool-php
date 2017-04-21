#!/usr/bin/php
<?php
$i = 0;
$result = NULL;
while ($argv[++$i])
	$result = $result . " " . $argv[$i];
$result = trim(preg_replace("/\s+/", " ", $result));
$array = explode(" ", $result);
sort($array);
$i = -1;
while ($array[++$i])
	echo $array[$i]."\n";
?>
