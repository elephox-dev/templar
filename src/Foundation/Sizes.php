<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Length;

abstract class Sizes {
	public static function NavbarHeight(): Length {
		return Length::inPx(56);
	}
}