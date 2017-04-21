#!/usr/bin/php
<?php
function get_ascii($char)
{
	$ascii = ord($char);
	if ($ascii == 0)
		return $ascii;
	if (($ascii < 48) || ($ascii >= 91 && $ascii <= 96) || ($ascii > 122))
		$ascii += 1000;
	else if (is_numeric($char))
		$ascii += 100;
	else if (ctype_upper($char))
		$ascii += 32;
	return $ascii;
}

function ssap2_cmp($string1, $string2)
{
	$len1 = strlen($string1);
	$len2 = strlen($string2);
	$i = 0;
	while ($i < $len1 && $i < $len2)
	{
		$a1 = get_ascii($string1[$i]);
		$a2 = get_ascii($string2[$i]);
		if ($a1 != $a2)
			return ($a1 < $a2 ? -1 : 1);
		$i++;
	}
	if ($len1 == $len2)
		return (0);
	return ($len1 == $i ? -1 : 1);
}

if ($argc <= 1)
	exit();
$i = 0;
while (++$i < $argc)
{
	$array = preg_split("/[ ]+/", $argv[$i], 0, PREG_SPLIT_NO_EMPTY);
	foreach ($array as $elem)
		$output[] = $elem;
}
usort($output, "ssap2_cmp");
foreach ($output as $elem)
	echo $elem."\n";
?>
