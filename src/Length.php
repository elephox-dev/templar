<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Length extends Value {
	public static function zero(LengthUnit $unit = LengthUnit::Px): Length {
		return new Length(
			0,
			$unit,
		);
	}

	public static function inPx(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Px,
		);
	}

	public static function inRem(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Rem,
		);
	}

	public static function inPercent(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Percent,
		);
	}

	public function __construct(
		private readonly float $value,
		private readonly LengthUnit $unit,
		private readonly int $precision = 2,
	) {}

	public function unit(): LengthUnit {
		return $this->unit;
	}

	public function value(): float {
		return $this->value;
	}

	public function precision(): int {
		return $this->precision;
	}
}
