#!/usr/bin/php
<?php
while(42)
{
	echo "Entrez un nombre: ";
	if (!($number = fgets(STDIN)) && print("\n"))
		exit;
	$number = trim($number);
	if (!is_numeric($number))
		echo "'$number' n'est pas un chiffre\n";
	else
		echo "Le chiffre $number est ".((($number % 2) == 0) ? "Pair" : "Impair")."\n";
}
?>
