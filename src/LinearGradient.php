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

		assert(
			count($this->stops) >= 2,
			"LinearGradient must have at least two stops, got " . count($this->stops)
		);
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->direction,
			...$this->stops,
		);
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
