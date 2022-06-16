<?php
declare(strict_types=1);

namespace Elephox\Templar;

class LinearGradient extends Gradient {
	/**
	 * @param iterable<float, Color> $stops
	 */
	public function __construct(
		iterable $stops,
		protected readonly Angle|GradientDirection $direction = GradientDirection::ToRight,
	) {
		parent::__construct($stops);
	}

	public function getHashCode(): int {
		return 0;
	}

	public function __toString(): string {
		return "linear-gradient({$this->renderDirection()}, {$this->renderStops()})";
	}

	protected function renderDirection(): string {
		if ($this->direction instanceof GradientDirection) {
			return $this->direction->value;
		}

		return (string)$this->direction;
	}

	protected function renderStops(): string {
		$stops = [];

		foreach ($this->stops as $stop => $color) {
			$percent = $stop * 100;
			$stops[] = "$color $percent%";
		}

		return implode(', ', $stops);
	}
}
