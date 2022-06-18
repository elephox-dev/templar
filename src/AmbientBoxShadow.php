<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;

class AmbientBoxShadow extends BoxShadow {
	public function __construct(
		protected readonly int $elevation,
		?Color $color = null,
	) {
		$yOffset = $elevation;
		$blurRadius = $elevation === 1 ? 3 : $elevation * 2;
		$alpha = (12 - round($elevation / 10)) / 100;
		$shadowColor = ($color ?? Colors::Black())->withOpacity($alpha);

		parent::__construct(
			offset: new Offset(y: $yOffset),
			blurRadius: $blurRadius,
			color: $shadowColor,
		);
	}
}