<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Stringable;

class Length implements Stringable
{
	public static function zero(Unit $unit = Unit::Px): Length {
		return new Length(0, $unit);
	}

	public function __construct(
		private readonly float $value,
		private readonly Unit $unit,
		private readonly int $precision = 2,
	) {}

	public function unit(): Unit
	{
		return $this->unit;
	}

	public function value(): float
	{
		return $this->value;
	}

	public function __toString(): string
	{
		return sprintf('%.' . $this->precision . 'f%s', $this->value, $this->unit->value);
	}
}
