#!/usr/bin/php
<?php
function ft_split($string)
{
	if ($string)
	{
		$string = trim(preg_replace("/\s+/", " ", $string));
		$array = explode(" ", $string);
		sort($array);
		return ($array);
	}
}
?>
