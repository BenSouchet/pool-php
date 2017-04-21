#!/usr/bin/php
<?php
function check_day($day)
{
	$days = array("lundi", "mardi", "mercredi", "jeudi", "vendredi","samedi","dimanche");
	$i = -1;
	while (++$i < count($days))
		if ($day == $days[$i])
			return ($i + 1);
	return (0);
}

function bissextile($year)
{
	if( (is_int($year / 4) && !is_int($year / 100)) || is_int($year / 400))
		return (1);
	return (0);
}

function check_date($num, $month, $year)
{
	if (!is_numeric($num) || $num < 1 || $num > 31)
		return (0);
	if ($month == "fevrier" && ($num < 28 || $num > 29 || ($num == 28 && bissextile($year)) || ($num == 29 && !bissextile($year))))
		return (0);
	if ($num > 30 && ($month == "avril" || $month == "juin" || $month == "septembre" || $month == "novembre"))
		return (0);
	return (1);
}

function check_month($month)
{
	$months = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juiller", "aout", "septembre", "octobre", "novembre", "decembre");
	$i = -1;
	while (++$i < count($months))
		if ($month == $months[$i])
			return ($i + 1);
	return (0);
}

function check_hour($hour)
{
	$tab = explode(":", $hour);
	$result = -1;
	if (count($tab) != 3)
		return (-1);
	if (!is_numeric($tab[0]) || !is_numeric($tab[1]) ||
		!is_numeric($tab[2]))
		return (-1);
	if (strlen($tab[0]) != 2 || strlen($tab[1]) != 2||
		strlen($tab[2]) != 2)
		return (-1);
	if ($tab[0] > 23 || $tab[0] < 0)
		return (-1);
	if ($tab[1] > 59 || $tab[1] < 0)
		return (-1);
	if ($tab[2] > 59 || $tab[2] < 0)
		return (-1);
	$result = $tab[2] + ($tab[1] * 60) + ($tab[0] * 3600);
	return ($result);
}

if ($argc != 2 && print("Wrong Format\n"))
	exit;
$argv[1] = trim(preg_replace("/\s+/", " ", $argv[1]));
$array = explode(" ", $argv[1]);
if (count($array) != 5 && print("Wrong Format\n"))
	exit;
$array[0] = strtolower($array[0]);
$array[2] = strtolower($array[2]);
$array[2] = strtr($array[2], 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
if ((!is_numeric($array[3]) || $array[3] > 9999 || $array[3] < 1970) && print("Wrong Format\n"))
	exit;
$year = $array[3];
if (!($day = check_day($array[0])) && print("Wrong Format\n"))
	exit;
if (!($month = check_month($array[2])) && print("Wrong Format\n"))
	exit;
if (!check_date($array[1], $array[2], $year) && print("Wrong Format\n"))
	exit;
if ((($hour = check_hour($array[4])) == -1) && print("Wrong Format\n"))
	exit;
$result = $year."/".$month."/".$array[1];
date_default_timezone_set('Europe/Paris');
$time = strtotime($result);
$time = $time + $hour;
echo $time."\n";
?>
