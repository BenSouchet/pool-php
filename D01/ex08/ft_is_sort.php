#!/usr/bin/php
<?php
function ft_is_sort($tab)
{
	$increase = $tab;
	$decrease = $tab;
	sort($increase);
	rsort($decrease);
	if ($tab != $increase && $tab != $decrease)
		return (0);
	return (1);
}
?>
