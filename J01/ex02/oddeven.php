#!/usr/bin/php
<?PHP
while (1)
{
	echo "Entrez un nombre: ";
	if (!($nb  = fgets(STDIN)))
	{
		echo "\n";
		exit;
	}
	$nb = trim($nb);
	if (!is_numeric($nb))
		echo "'$nb' n'est pas un chiffre\n";
	else
		echo "Le chiffre $nb est ".((($nb % 2) == 0) ? "Pair" : "Impair")."\n";
}
?>