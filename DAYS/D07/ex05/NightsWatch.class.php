<?php
class NightsWatch
{
	private $_fighters = [];
	public function recruit($w)
	{
		$this->_fighters[] = $w;
	}
	public function fight()
	{
		foreach ($this->_fighters as $f)
		{
			if ($f instanceof IFighter)
				$f->fight();
		}
	}
}
?>
