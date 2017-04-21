#!/usr/bin/php
<?php
function search_it($array, $search)
{
	$result = NULL;
	$i = 2;
	while ($array[$i])
	{
		$tmp = explode(":", $array[$i]);
		if ($tmp[0] == $search)
			$result = $tmp[1];
		$i++;
	}
	if ($result)
		echo $result . "\n";
}
if (!$argv[1] && $argv[1] != 0 || !$argv[2] && $argv[2] != 0)
	return ;
$search = $argv[1];
search_it($argv, $search);
?>
