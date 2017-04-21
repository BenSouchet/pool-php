#!/usr/bin/php
<?php
if ($argc != 4 && print("Incorrect Parameters\n"))
	exit;
$number1 = trim($argv[1]);
$operator = trim($argv[2]);
$number2 = trim($argv[3]);
if (!is_numeric($number1) && print("Incorrect Parameters\n"))
	exit;
if (!is_numeric($number2) && print("Incorrect Parameters\n"))
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
else if (print("Incorrect Parameters\n"))
	exit;

echo $result . "\n";
?>
