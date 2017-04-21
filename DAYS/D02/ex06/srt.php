#!/usr/bin/php
<?php
if ($argc != 2 && print("usage : srt.php FILE\n"))
	exit;
if ((file_exists($argv[1]) == FALSE || ($fd = fopen($argv[1], "r")) == FALSE) && print("error : failed to open.\n"))
	exit;
fclose($fd);
$str_file = file($argv[1]);
$lines = count($str_file);
$count = -1;
$n_str = array();
while (++$count < $lines)
	if ($str_file[$count] != "\n")
		array_push($n_str, $str_file[$count]);
$n_lines = count($n_str);
$nb_sub = $n_lines / 3;
if ($nb_sub % 1 != 0.0 && print("error : wrong number of lines.\n"))
	exit;
$i = -1;
$global = array();
$timecode = array();
while (++$i < $nb_sub)
{
	$file_data = array_slice($n_str, 3 * $i, 3);
	$file_data[0] = preg_replace('/[^0-9+]/', '', substr($file_data[1], 0, 12));
	if (($last = $file_data[2][strlen($file_data[2]) - 1]) != "\n")
		$file_data[2] = $file_data[2] . "\n";
	array_push($global, $file_data);
	array_push($timecode, $file_data[0]);
}
sort($timecode, SORT_NUMERIC);
$i = -1;
$timecode_nb = 0;
while (++$i < $nb_sub)
{
	$j = -1;
	echo $i + 1 . "\n";
	while (++$j < $nb_sub && $timecode[$timecode_nb] != $global[$j][0]);
	++$timecode_nb;
	echo $global[$j][1] . $global[$j][2] . (($i == $nb_sub - 1) ? "" : "\n");
}
?>
