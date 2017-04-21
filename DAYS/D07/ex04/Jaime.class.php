<?php
class Jaime extends Lannister
{
	public function withWho($pers)
	{
		if (get_class($pers) === "Tyrion")
			return ("Not even if I'm drunk !");
		else if (get_class($pers) === "Sansa")
			return ("Let's do this.");
		else
			return ("With pleasure, but only in a tower in Winterfell, then.");
	}
}
?>
