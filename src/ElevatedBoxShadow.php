<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;

class ElevatedBoxShadow extends BoxShadow {
	public function __construct(
		protected readonly int $elevation,
		?Color $color = null
	) {
		if ($elevation > 0) {
			$yOffset = 1 + 0.1 * log($elevation + 1) * $elevation;
			$blurRadius = 2 + 0.3 * log($elevation + 2) * $elevation;
		} else {
			$yOffset = 1;
			$blurRadius = 3;
		}

		$alpha = (24 - round($elevation / 10)) / 100;
		$shadowColor = ($color ?? Colors::Black())->withOpacity($alpha);

		parent::__construct(
			offset: new Offset(y: $yOffset),
			blurRadius: $blurRadius,
			color: $shadowColor,
		);
	}

	public function withAmbient(): array {
		return [
			$this,
			BoxShadow::ambient(
				$this->elevation,
				$this->color->withOpacity(1)
			),
		];
	}
}