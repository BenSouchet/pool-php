#!/usr/bin/php
<?php
if ($argc != 2 && print("Incorrect Parameters\n"))
	exit;
$argv[1] = trim(preg_replace("/\s+/", "", $argv[1]));
$i = -1;
while ($argv[1][++$i])
{
	if (strstr("0123456789-+*/%", $argv[1][$i]) == FALSE &&
	print("Syntax Error\n"))
		exit;
}
$number1 = NULL;
$operator = NULL;
$number2 = NULL;
$i = 0;
if ($argv[1][$i] == '-' || $argv[1][$i] == '+')
	$number1 = $number1 . $argv[1][$i++];
while ($argv[1][$i] && strstr("0123456789", $argv[1][$i]))
	$number1 = $number1 . $argv[1][$i++];
if ($argv[1][$i])
	$operator = $operator . $argv[1][$i++];
if ($argv[1][$i] && ($argv[1][$i] == '-' || $argv[1][$i] == '+'))
	$number2 = $number2 . $argv[1][$i++];
while ($argv[1][$i] && strstr("0123456789", $argv[1][$i]))
	$number2 = $number2 . $argv[1][$i++];
if ($argv[1][$i] && print("Syntax Error\n"))
	exit;
if (!is_numeric($number1) && print("Syntax Error\n"))
	exit;
if (!is_numeric($number2) && print("Syntax Error\n"))
	exit;
if ($operator == "-")
	$result = $number1 - $number2;
else if ($operator == "+")
	$result = $number1 + $number2;
else if ($operator == "*")
	$result = $number1 * $number2;
else if ($operator == "/")
{
	if ($number2 == 0)
		exit;
	$result = $number1 / $number2;
}
else if ($operator == "%")
{
	if ($number2 == 0)
		exit;
	$result = $number1 % $number2;
}
else if (print("Syntax Error\n"))
	exit;
echo $result . "\n";
?>
