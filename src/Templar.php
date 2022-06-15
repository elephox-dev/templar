<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Templar
{
	public function render(Widget $widget): void
	{
		echo $widget->render();
	}
}
