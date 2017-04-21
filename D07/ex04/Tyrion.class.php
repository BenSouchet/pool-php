<?php
class Tyrion extends Lannister
{
	public function withWho($pers)
	{
		if (get_class($pers) === "Jaime" || get_class($pers) === "Cersei")
			return ("Not even if I'm drunk !");
		else
			return ("Let's do this.");
	}
}
?>
